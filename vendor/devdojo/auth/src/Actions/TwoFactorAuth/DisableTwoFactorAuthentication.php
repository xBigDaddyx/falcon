<?php

namespace Devdojo\Auth\Actions\TwoFactorAuth;

use Devdojo\Auth\Events\TwoFactorAuthenticationDisabled;
use Devdojo\Auth\Models\User;

class DisableTwoFactorAuthentication
{
    /**
     * Disable two factor authentication for the user.
     *
     * @return void
     */
    public function __invoke($user)
    {
        if (! is_null($user->two_factor_secret) ||
            ! is_null($user->two_factor_recovery_codes) ||
            ! is_null($user->two_factor_confirmed_at)) {
            $user->forceFill([
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ])->save();

            TwoFactorAuthenticationDisabled::dispatch($user);
        }
    }
}
