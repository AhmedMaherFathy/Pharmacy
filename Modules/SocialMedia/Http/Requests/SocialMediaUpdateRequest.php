<?php

namespace Modules\SocialMedia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ValidationRuleHelper;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;

class SocialMediaUpdateRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'platform' => ValidationRuleHelper::platformRule(['required'=>'sometimes']),
            'link' => ValidationRuleHelper::platformRule(['required'=>'sometimes']),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
