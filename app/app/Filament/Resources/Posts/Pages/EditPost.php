<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Concerns\ManagesLegacyImages;
use App\Filament\Resources\Posts\PostResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPost extends EditRecord
{
    use ManagesLegacyImages;

    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
