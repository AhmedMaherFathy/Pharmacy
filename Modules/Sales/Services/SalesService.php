<?php 
namespace Modules\Sales\Services;

use App\Exceptions\ValidationErrorsException;
use App\Traits\HttpResponse;
use Modules\Sales\Entities\Sales;
use Illuminate\Support\Facades\DB;
use Modules\Product\Entities\Product;

class SalesService{
    // use HttpResponse;
    public function store($validated){
            DB::transaction(function () use ($validated) {
            $sale = new Sales(); //invoice
            $sale->sale_time = now(); 
            $sale->save();
    
            $ids = [];
            foreach($validated['products'] as $requestData)
            {
                $ids[$requestData['product_id']] = ['quantity' => $requestData['quantity']];
            }

            // info($ids);

            // die;

            $requestKeys = array_keys($ids);

            $errors['products.$index'] = 'product not found';
            $existingProducts = Product::whereIn('id', $requestKeys)->get();

            $resultIds = $existingProducts->pluck('id')->toArray();

            $totalProfits = $index = 0;

            $errors = [];

            foreach($requestKeys as $key)
            {
                // if (! in_array($key, $resultIds))
                // {
                //     $errors["products.$index"] = "product not found";

                //     throw new ValidationErrorsException($errors);
                //     // info($errors);
                // }
                // Validation
                throw_if(
                    !in_array($key, $resultIds), 
                    ValidationErrorsException::class,
                    ["products.$index" => "product not found"]
                );
                $index++;
            }

            

            foreach($existingProducts as $product)
            {
                // if($product->quantity < $ids[$product->id]['quantity'])
                // {
                //     throw new ValidationErrorsException([
                //         "products.$index" => "Not enough quantity",
                //     ]);
                // }N
                throw_if(
                    $product->quantity < $ids[$product->id]['quantity'], 
                    ValidationErrorsException::class,
                    ["products.$index" => "Not enough quantity"]
                );
                $totalProfits += ($product->sell_price - $product->buy_price) * $ids[$product->id]['quantity'];
                $index++;
            }
            // info("total profit is".$totalProfits);
            
            // DB::transaction(function() use ($totalProfit, $ids, $existingProducts){
                $sale->update(['profit' => $totalProfits]);

                $sale->products()->attach($ids);

                // foreach($existingProducts as $product)
                // {
                //     $product->decrement('quantity', $ids[$product->id]['quantity']);
                // }

                $existingProducts->each(
                    fn($product) => $product->decrement('quantity', $ids[$product->id]['quantity'])
                );
            });
        //     die;
        //     foreach ($validated as $productData) {
        //         $productId = $productData['product_id'];
        //         $quantity = $productData['quantity'];
    
        //         $product = Product::findOrFail($productId);
        //         $sale->products()->attach($product->id, ['quantity' => $quantity]);
        //         $productProfit = ($product->sell_price - $product->buy_price) * $quantity;
    
        //         $product->quantity -= $quantity;
        //         $product->save();
    
        //         $totalProfit += $productProfit;
        //     }
    
        //     $sale->update(['profit' => $totalProfit]);
        //     // DB::commit();

        //     return null;
        // } catch (\Exception $e) {
        //     // DB::rollback();
        //     return  $e->getMessage();
        // }
    }
}