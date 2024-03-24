<?php

namespace Modules\Sales\Http\Requests;

use Illuminate\Validation\Rule;
use App\Helpers\ValidationRuleHelper;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Modules\Product\Entities\Product;

class SalesRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            '*.product_id' => 'required',
            '*.quantity' => 'required|integer|min:1',
        ];  
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
