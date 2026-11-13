<?php

namespace App\Filament\Resources\Courses\Pages;

use App\Filament\Concerns\ManagesLegacyImages;
use App\Filament\Resources\Courses\CourseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCourse extends EditRecord
{
    use ManagesLegacyImages;

    protected static string $resource = CourseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
