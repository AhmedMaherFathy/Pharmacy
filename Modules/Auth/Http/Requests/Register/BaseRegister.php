<?php

namespace Modules\Auth\Http\Requests\Register;

use App\Helpers\ValidationRuleHelper;
use App\Models\User;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class BaseRegister extends FormRequest
{
    use HttpResponse;

    public function rules()
    {

    }

    public static function baseRules(bool $excludeAvatar = false, bool $inUpdate = false, $idValue = null): array
    {
        return [
            'name' => ValidationRuleHelper::stringRules(),
            'phone' => ValidationRuleHelper::phoneRules(),
            'email' => ValidationRuleHelper::emailRules([
                'unique' => ValidationRuleHelper::getUniqueColumn($inUpdate, (new User())->getTable(), $idValue),
            ]),
            'password' => ValidationRuleHelper::defaultPasswordRules([
                'required' => $inUpdate ? 'sometimes' : 'required',
            ]),
            // 'avatar' => ValidationRuleHelper::storeOrUpdateImageRules($inUpdate, [
            //     // 'required' => $excludeAvatar ? 'exclude' : ($inUpdate ? 'sometimes' : 'required'),
            //     'required'=> 'sometimes',
            // ]),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
