<?php

namespace App\Filament\Resources\Courses;

use App\Filament\Resources\Courses\Pages\CreateCourse;
use App\Filament\Resources\Courses\Pages\EditCourse;
use App\Filament\Resources\Courses\Pages\ListCourses;
use App\Models\Course;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Corsi';

    protected static ?string $modelLabel = 'corso';

    protected static ?string $pluralModelLabel = 'corsi';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Titolo')->required()->maxLength(100),
                Textarea::make('text')->label('Testo')->maxLength(4000)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                TextInput::make('schedule')->label('Giorni e orario')->required()->maxLength(200),
                FileUpload::make('image_upload')->label('Immagine')->image()->acceptedFileTypes(['image/jpeg', 'image/png'])->rules(['dimensions:max_width=10000,max_height=10000'])->maxSize(10240)->storeFiles(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label('Titolo')->searchable()->sortable(),
                TextColumn::make('text')->label('Testo')->limit(50)->searchable(),
                TextColumn::make('schedule')->label('Orario')->limit(50),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCourses::route('/'),
            'create' => CreateCourse::route('/create'),
            'edit' => EditCourse::route('/{record}/edit'),
        ];
    }
}
