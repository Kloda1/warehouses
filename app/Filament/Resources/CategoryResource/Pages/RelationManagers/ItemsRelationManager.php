<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use App\Filament\Resources\ItemResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'الأصناف';
    protected static ?string $label = 'صنف';
    protected static ?string $pluralLabel = 'الأصناف';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('اسم الصنف')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('code')
                    ->label('الكود')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                    
                Forms\Components\Select::make('unit')
                    ->label('الوحدة')
                    ->required()
                    ->options([
                        'قطعة' => 'قطعة',
                        'علبة' => 'علبة',
                        'كرتون' => 'كرتون',
                        'كيلو' => 'كيلو',
                        'لتر' => 'لتر',
                        'متر' => 'متر',
                        'زوج' => 'زوج',
                        'دزينة' => 'دزينة',
                    ])
                    ->default('قطعة'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label('الكود')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('unit')
                    ->label('الوحدة')
                    ->badge()
                    ->color('gray'),
                    
                Tables\Columns\TextColumn::make('current_quantity')
                    ->label('الكمية')
                    ->numeric()
                    ->formatStateUsing(fn ($state): string => number_format($state, 2)),
                    
                Tables\Columns\TextColumn::make('sale_price')
                    ->label('سعر البيع')
                    ->money('USD'),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة صنف'),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('عرض')
                    ->url(fn ($record) => ItemResource::getUrl('view', ['record' => $record]))
                    ->openUrlInNewTab(),
                    
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}