<?php

namespace App\Filament\Auth;

use Filament\Auth\Pages\Login;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Support\Components\Attributes\Unexposed;
use SensitiveParameter;

class AdminLogin extends Login
{
    #[Unexposed]
    public function form(Schema $schema): Schema
    {
        return $schema->components([
            $this->getEmailFormComponent(),
            $this->getPasswordFormComponent(),
        ]);
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('E-mail')
            ->email()
            ->required()
            ->autocomplete('email')
            ->autofocus();
    }

    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        return ['email' => $data['email'], 'password' => $data['password']];
    }
}
