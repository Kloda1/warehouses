<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';
    protected static ?string $title = 'الفئات الفرعية';
    protected static ?string $label = 'فئة فرعية';
    protected static ?string $pluralLabel = 'الفئات الفرعية';
    protected static ?string $recordTitleAttribute = 'name';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('اسم الفئة الفرعية')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                if (!empty($state)) {
                                    $code = Str::slug(Str::substr($state, 0, 20), '_');
                                    $set('code', strtoupper($code));
                                }
                            }),
                            
                        Forms\Components\TextInput::make('code')
                            ->label('الكود')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->disabled(),
                    ]),
                    
                Forms\Components\Textarea::make('description')
                    ->label('الوصف')
                    ->rows(2)
                    ->maxLength(500)
                    ->columnSpanFull(),
                    
                Forms\Components\Toggle::make('is_active')
                    ->label('نشط')
                    ->default(true)
                    ->inline(false),
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
                    
                Tables\Columns\TextColumn::make('description')
                    ->label('الوصف')
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                    
                Tables\Columns\TextColumn::make('items_count')
                    ->label('عدد الأصناف')
                    ->numeric()
                    ->sortable(),
                    
                Tables\Columns\IconColumn::make('is_active')
                    ->label('نشط')
                    ->boolean(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإنشاء')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('الحالة'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('إضافة فئة فرعية'),
            ])
            ->actions([
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