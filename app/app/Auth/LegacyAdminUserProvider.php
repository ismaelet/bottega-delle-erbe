<?php

namespace App\Auth;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use SensitiveParameter;

class LegacyAdminUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(#[SensitiveParameter] array $credentials)
    {
        $login = $credentials['email'] ?? null;
        if (! is_string($login) || $login === '') {
            return null;
        }

        return $this->newModelQuery()
            ->where('guest', 0)
            ->where('admin', '>', 0)
            ->where('mail', $login)
            ->first();
    }

    public function validateCredentials(Authenticatable $user, #[SensitiveParameter] array $credentials)
    {
        $password = $credentials['password'] ?? null;
        $stored = $user->getAuthPassword();
        if (! is_string($password) || $password === '' || ! is_string($stored) || $stored === '') {
            return false;
        }

        if (str_starts_with($stored, '$')) {
            return password_verify($password, $stored);
        }

        if (preg_match('/\A[0-9a-f]{32}\z/i', $stored)) {
            return hash_equals(strtolower($stored), md5($password));
        }

        return hash_equals($stored, $password);
    }

    public function rehashPasswordIfRequired(Authenticatable $user, #[SensitiveParameter] array $credentials, bool $force = false)
    {
        $stored = $user->getAuthPassword();
        if (! $force && ! $this->hasher->needsRehash($stored)) {
            return;
        }

        $newPassword = $this->hasher->make($credentials['password']);
        $updated = $this->newModelQuery()->whereKey($user->getAuthIdentifier())
            ->where($user->getAuthPasswordName(), $stored)
            ->update([$user->getAuthPasswordName() => $newPassword]);
        if ($updated !== 1) {
            throw new AuthenticationException('The administrator password changed during sign-in.');
        }

        $user->setAttribute($user->getAuthPasswordName(), $newPassword);
    }
}
