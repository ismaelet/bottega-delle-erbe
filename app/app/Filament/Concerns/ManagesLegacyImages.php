<?php

namespace App\Filament\Concerns;

use App\Services\AdminImages;
use Illuminate\Database\Eloquent\Model;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use RuntimeException;
use Throwable;

trait ManagesLegacyImages
{
    protected function handleRecordCreation(array $data): Model
    {
        $upload = $data['image_upload'] ?? null;
        unset($data['image_upload']);
        if ($upload !== null && ! $upload instanceof TemporaryUploadedFile) {
            throw new RuntimeException('Immagine caricata non valida.');
        }

        $record = parent::handleRecordCreation($data);
        try {
            if ($upload instanceof TemporaryUploadedFile) {
                app(AdminImages::class)->save($record, $upload);
            }
        } catch (Throwable $exception) {
            if (! $record->delete()) {
                throw new RuntimeException('Impossibile annullare la creazione dopo l’errore di caricamento.', previous: $exception);
            }
            throw $exception;
        }

        return $record;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $upload = $data['image_upload'] ?? null;
        unset($data['image_upload']);
        if ($upload !== null && ! $upload instanceof TemporaryUploadedFile) {
            throw new RuntimeException('Immagine caricata non valida.');
        }
        $previousType = $record->getAttribute('type');
        $record->fill($data);
        app(AdminImages::class)->save($record, $upload, $previousType);

        return parent::handleRecordUpdate($record, $data);
    }
}
