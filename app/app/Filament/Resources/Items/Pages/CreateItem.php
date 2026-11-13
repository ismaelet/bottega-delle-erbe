<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Concerns\ManagesLegacyImages;
use App\Filament\Resources\Items\ItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateItem extends CreateRecord
{
    use ManagesLegacyImages;

    protected static string $resource = ItemResource::class;
}
