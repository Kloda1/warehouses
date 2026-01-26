<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ItemResource\Pages;
use App\Filament\Resources\ItemResource\RelationManagers;
use App\Models\Item;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model; 

class ItemResource extends Resource
{
    protected static ?string $model = Item::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('category_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('unit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('purchase_price')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('sale_price')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('wholesale_price')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('minimum_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('opening_balance')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('current_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('reserved_quantity')
                    ->required()
                    ->numeric()
                    ->default(0.00),
                Forms\Components\TextInput::make('barcode')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('last_updated_by')
                    ->numeric()
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('wholesale_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('minimum_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opening_balance')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('current_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reserved_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('barcode')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('last_updated_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }
 public static function getGlobalSearchResultDetails(Model $record): array  
    {
        return [
            'الكود' => $record->code,
            'الفئة' => $record->category?->name ?? '---',
            'الوحدة' => $record->unit,
            'الكمية' => number_format($record->current_quantity, 2),
            'سعر البيع' => '$' . number_format($record->sale_price, 2),
        ];
    }
    
    public static function getGlobalSearchResultUrl(Model $record): string  
    {
        return self::getUrl('view', ['record' => $record]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListItems::route('/'),
            'create' => Pages\CreateItem::route('/create'),
            'edit' => Pages\EditItem::route('/{record}/edit'),
        ];
    }
}
