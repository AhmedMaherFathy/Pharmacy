<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ValidationRuleHelper;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;

class ProductRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'name'=>'required|max:255',
            'quantity'=>'integer|gt:0',
            'buy_price'=>'min:0',
            'sell_price'=>'min:0',
            'category_id'=>'required',
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
