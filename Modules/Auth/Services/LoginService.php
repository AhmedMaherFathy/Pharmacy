<?php

namespace Modules\Auth\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Contracts\VerifyUser;
use Modules\Auth\Enums\AuthEnum;
use Modules\Auth\Enums\UserStatusEnum;
use Psr\SimpleCache\InvalidArgumentException;

class LoginService
{
    /**
     * @throws InvalidArgumentException
     */
    public function loginSpa(array $validatedData): bool|User|array
    {
        return $this->loginUser($validatedData);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function loginMobile(array $validatedData): User|bool|array
    {
        return $this->loginUser($validatedData, true);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function loginUser(array $validatedData, bool $isMobile = false): bool|User|array
    {
        $errors = [];
        $user = User::query()
            ->where(AuthEnum::UNIQUE_COLUMN, $validatedData[AuthEnum::UNIQUE_COLUMN])
            ->whereValidType($isMobile)
            // ->with(AuthEnum::AVATAR_RELATIONSHIP_NAME)
            ->first();

        if ($this->userNotFoundOrHaveWrongPassword($user, $validatedData['password'], $user->password ?? null)) {
            return false;
        }
        //

        if (UserStatusEnum::isInActive($user)) {
            $errors['frozen'] = 1;

            return $errors;
        }

        if (! $this->isVerified($user)) {
            $errors['not_verified'] = true;

            return $errors;
        }

        auth()->login($user);

        //UserHelper::loadAdditionalRelations($user);
        //$user->forceFill(['fcm_token' => $validatedData['fcm_token']]);
        //$user->save();

        $this->addTokenIfMobile($user, $isMobile);

        return $user;
    }

    private function userNotFoundOrHaveWrongPassword($user, string $requestPassword, ?string $existingUserPassword = null): bool
    {
        return ! $user || ! Hash::check($requestPassword, $existingUserPassword);
    }

    private function addTokenIfMobile(User $user, bool $isMobile): void
    {
        $expiresAt = config('sanctum.expiration');

        if ($expiresAt) {
            $expiresAt = now()->addMinutes($expiresAt);
        }

        $user->token = $user->createToken(
            $user->name ?: 'Sample User',
            expiresAt: $expiresAt
        )
            ->plainTextToken;
    }

    public function isVerified($user): bool
    {
        return (bool) $user->{AuthEnum::VERIFIED_AT};
    }
}
