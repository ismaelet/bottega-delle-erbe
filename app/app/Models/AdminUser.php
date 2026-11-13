<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AdminUser extends Authenticatable implements FilamentUser, HasName
{
    protected $table = 'users';

    public $timestamps = false;

    protected $hidden = ['password'];

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin' && $this->isAdministrator();
    }

    public function isAdministrator(): bool
    {
        return ! $this->guest && (int) $this->admin > 0;
    }

    public function getFilamentName(): string
    {
        return $this->username ?: $this->mail;
    }
}
