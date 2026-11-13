<?php

namespace App\Filament\Resources\Items;

use App\Filament\Resources\Items\Pages\CreateItem;
use App\Filament\Resources\Items\Pages\EditItem;
use App\Filament\Resources\Items\Pages\ListItems;
use App\Models\Item;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Prodotti';

    protected static ?string $modelLabel = 'prodotto';

    protected static ?string $pluralModelLabel = 'prodotti';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label('Nome')->required()->maxLength(50),
                Select::make('type')->label('Tipo')->options(fn () => DB::table('items_types')->orderBy('name')->pluck('name', 'tag')->all())->required(),
                TextInput::make('tech')->label('Dati tecnici')->maxLength(100)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                Textarea::make('info')->label('Descrizione')->maxLength(500)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                Textarea::make('ingredients')->label('Ingredienti')->maxLength(800)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                Textarea::make('methods')->label("Modi d'uso")->maxLength(400)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                Textarea::make('warnings')->label('Avvertenze')->maxLength(600)->default('')->dehydrateStateUsing(fn (?string $state) => $state ?? ''),
                TextInput::make('price')->label('Prezzo (€)')->numeric()->minValue(0)->required()->default(0),
                Select::make('uses')->label('Esigenze')->multiple()->options(fn () => DB::table('items_uses')->orderBy('id')->pluck('name', 'tag')->all())
                    ->formatStateUsing(fn (array|string|null $state) => collect(is_array($state) ? $state : [$state])->flatMap(fn (?string $value) => explode(',', $value ?? ''))->filter()->values()->all())
                    ->dehydrateStateUsing(fn (?array $state) => implode(',', $state ?? [])),
                FileUpload::make('image_upload')->label('Immagine')->image()->acceptedFileTypes(['image/jpeg', 'image/png'])->rules(['dimensions:max_width=10000,max_height=10000'])->maxSize(10240)->storeFiles(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('ID')->sortable()->searchable(),
                TextColumn::make('name')->label('Nome')->searchable()->sortable(),
                TextColumn::make('type')->label('Tipo')->formatStateUsing(fn (string $state) => DB::table('items_types')->where('tag', $state)->value('name') ?? $state)
                    ->searchable(query: fn (Builder $query, string $search) => $query->orWhereIn('type', DB::table('items_types')->select('tag')->where('name', 'like', '%'.$search.'%'))),
                TextColumn::make('ingredients')->label('Ingredienti')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('price')->label('Prezzo')->money('EUR')->sortable(),
                TextColumn::make('time')->label('Data')->date()->sortable(),
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
            'index' => ListItems::route('/'),
            'create' => CreateItem::route('/create'),
            'edit' => EditItem::route('/{record}/edit'),
        ];
    }
}
