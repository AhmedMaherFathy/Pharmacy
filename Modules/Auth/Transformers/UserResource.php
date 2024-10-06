<?php

namespace Modules\Auth\Transformers;

use App\Helpers\ResourceHelper;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Enums\AuthEnum;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->whenHas('status'),
            'phone' => $this->whenHas('phone'),
            // 'rolesIds' => $this->whenHas('rolesIds'),
            AuthEnum::UNIQUE_COLUMN => $this->whenHas(AuthEnum::UNIQUE_COLUMN),
            'avatar' => $this->whenNotNull(
                ResourceHelper::getMedia(
                    AuthEnum::AVATAR_COLLECTION_NAME,
                    $this,
                    AuthEnum::AVATAR_RELATIONSHIP_NAME,
                    'user.png'
                )
            ),
            'type' => $this->whenHas('type'),
            'token' => $this->whenHas('token'),
            // $this->mergeWhen($this->relationLoaded('roles'), function () {
            //     $role = $this->roles->first();
            //     $permissions = [];

            //     if ($role?->relationLoaded('permissions')) {
            //         foreach ($role->permissions as $permission) {
            //             $permissions[] = $permission->name;
            //         }
            //     }

            //     return [
            //         'permissions' => $this->when((bool) $permissions, $permissions),
            //     ];
            // }),
        ];
    }
}
