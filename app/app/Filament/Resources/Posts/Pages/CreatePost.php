<?php

namespace App\Filament\Resources\Posts\Pages;

use App\Filament\Concerns\ManagesLegacyImages;
use App\Filament\Resources\Posts\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    use ManagesLegacyImages;

    protected static string $resource = PostResource::class;
}
