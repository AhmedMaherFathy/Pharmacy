<?php

namespace Modules\Auth\Http\Requests\Register;

use App\Helpers\ValidationRuleHelper;
use Elattar\Prepare\Traits\HttpResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Modules\DeliveryMan\Enums\DeliveryWayEnum;

class DeliveryRegisterRequest extends FormRequest
{
    use HttpResponse;

    public function rules()
    {
        return [
            ...BaseRegister::baseRules(),
            'front_national_id' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'back_national_id' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'criminal_record_certificate' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'academic_qualification' => ValidationRuleHelper::storeOrUpdateImageRules(true),
            'personal_license' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'viechel_license' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'delivery_way_photo' => ValidationRuleHelper::storeOrUpdateImageRules(),
            'national_id' => ValidationRuleHelper::integerRules(),
            'delivery_way' => ValidationRuleHelper::enumRules(DeliveryWayEnum::availableTypes()),
            'latitude' => ValidationRuleHelper::latitudeRules(),
            'longitude' => ValidationRuleHelper::longitudeRules(),
        ];
    }

    public function failedValidation(Validator $validator): void
    {
        $this->throwValidationException($validator);
    }
}
