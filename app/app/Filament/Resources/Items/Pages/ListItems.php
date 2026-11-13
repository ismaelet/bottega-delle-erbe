<?php

namespace App\Filament\Resources\Items\Pages;

use App\Filament\Resources\Items\ItemResource;
use App\Services\ProductCsvImport;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class ListItems extends ListRecords
{
    protected static string $resource = ItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
            Action::make('import')
                ->label('Importa CSV')
                ->schema([
                    FileUpload::make('file')->label('File CSV')->required()->acceptedFileTypes(['text/csv', 'text/plain', 'application/csv', 'application/vnd.ms-excel', 'application/octet-stream'])->maxSize(10240)->storeFiles(false),
                    Toggle::make('updateOnly')->label('Solo aggiornamento')->default(true),
                ])
                ->action(function (Action $action, array $data): void {
                    if (! $data['file'] instanceof TemporaryUploadedFile) {
                        throw new \RuntimeException('File CSV non disponibile.');
                    }

                    try {
                        $missing = app(ProductCsvImport::class)->import($data['file'], $data['updateOnly']);
                    } catch (ValidationException $exception) {
                        Notification::make()->title('Importazione non riuscita')->body($exception->getMessage())->danger()->persistent()->send();
                        $action->halt();
                    }
                    $notification = Notification::make()->title('Importazione completata');
                    if ($missing !== []) {
                        $notification->warning()->body('Prodotti non trovati: '.implode(', ', $missing))->persistent();
                    } else {
                        $notification->success();
                    }
                    $notification->send();
                }),
        ];
    }
}
