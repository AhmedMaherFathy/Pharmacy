<?php

namespace Modules\Auth\Actions\Register;

use App\Services\FileOperationService;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Auth\Helpers\UserCollectionHelper;

class DeliveryRegisterAction
{
    public function handle(array $data)
    {
        $data['type'] = UserTypeEnum::DELIVERY;

        $data['additional_addresses'] = [
            [
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ],
        ];

        $delivery = (new BaseRegisterAction)->handle($data, function ($user, $errors, $data) {
            $fileOperationService = new FileOperationService();

            $delivery = $user->delivery()->create($data);

            $collectionNames = [
                'front_national_id' => UserCollectionHelper::frontNationalId(),
                'back_national_id' => UserCollectionHelper::backNationalId(),
                'criminal_record_certificate' => UserCollectionHelper::criminalRecordCertificate(),
                'personal_license' => UserCollectionHelper::personalLicense(),
                'viechel_license' => UserCollectionHelper::viechelLicense(),
                'delivery_way_photo' => UserCollectionHelper::deliveryWayPhoto(),
                'avatar' => 'avatar',
            ];

            foreach ($collectionNames as $fileName => $collectionName) {
                $fileOperationService->storeImageFromRequest($delivery, $collectionName, $fileName);
            }

            if (isset($data['academic_qualification'])) {
                $fileOperationService->storeImageFromRequest(
                    $delivery,
                    UserCollectionHelper::academicQualification(),
                    'academic_qualification',
                );
            }
        });

        BaseRegisterAction::notifyNewRegister($delivery);

        return true;
    }
}
