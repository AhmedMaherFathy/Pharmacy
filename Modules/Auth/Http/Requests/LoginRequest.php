<?php

namespace Modules\Auth\Http\Requests;

use App\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Facades\Captcha;
use Modules\Auth\Facades\IsEnabled;
use Modules\GeneralConfig;

class LoginRequest extends FormRequest
{
    use HttpResponse;

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            AuthEnum::UNIQUE_COLUMN => ['required'],
            'password' => ['required'],
            'fcm_token' => ['sometimes', 'string'],
        ];
    }

    /**
     * @throws ValidationException
     */
    
    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
