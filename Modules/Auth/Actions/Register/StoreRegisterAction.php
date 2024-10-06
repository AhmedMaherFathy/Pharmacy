<?php

namespace Modules\Auth\Actions\Register;

use App\Models\User;
use Modules\Auth\Enums\UserTypeEnum;
use Modules\Store\Helpers\BranchHelper;

class StoreRegisterAction
{
    public function handle(array $data)
    {
        $data['type'] = UserTypeEnum::STORE;

        $store = (new BaseRegisterAction)->handle($data, function (User $user, $errors, $data) {
            $store = $user->store()->create();

            $mainBranch = $store->branches()->create([
                'name' => $data['store_name'],
                'user_id' => $store->user_id,
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
                'is_main_branch' => true,
            ]);

            BranchHelper::storeBranchMedia($mainBranch);
        });

        BaseRegisterAction::notifyNewRegister($store);

        return true;
    }
}
