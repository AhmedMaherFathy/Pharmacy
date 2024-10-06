<?php

namespace Modules\Auth\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Modules\Auth\Enums\UserTypeEnum;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Role::create(['name' => UserTypeEnum::ADMIN]);
        foreach (UserTypeEnum::availableTypes() as $type) {
            $user = User::create([
                'name' => $type,
                'email' => "$type@admin.com",
                'email_verified_at' => now(),
                'status' => true,
                'password' => $type,
                'phone' => '051948961',
                'type' => $type,
                //'pass_code' => $type == UserTypeEnum::USER ? 12345 : null,
            ]);

            // if ($type != UserTypeEnum::CLIENT) {
            //     $user->assignRole($type);
            // }
        }
    }
}
