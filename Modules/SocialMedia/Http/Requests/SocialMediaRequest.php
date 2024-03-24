<?php

namespace Modules\SocialMedia\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Helpers\ValidationRuleHelper;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;

class SocialMediaRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            'platform' => ValidationRuleHelper::platformRule(),
            'link'=> ValidationRuleHelper::linkRules(),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
