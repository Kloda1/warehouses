<?php

namespace App\Filament\Resources\GoodsReceiptNotes\Tables;

use Dom\Text;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Resources\Form;
use Filament\Forms\Schema as FormsSchema;

class GoodsReceiptNotesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
        TextColumn::make('memo_number')->label('رقم المذكرة'),
        TextColumn::make('order_number')->label('رقم الطلب'),
        TextColumn::make('folder_number')->label('رقم المجلد'),
        TextColumn::make('invoice_number')->label('رقم الفاتورة'),
        TextColumn::make('date')->label(' التاريخ'), 
        TextColumn::make('financial_memo_number')->label('رقم المذكرة المالي'),
        TextColumn::make('invoice_date')->label('تاريخ الفاتورة'),
        TextColumn::make('order_date')->label('تاريخ الطلب'),
        TextColumn::make('deliver')->label('اسم المورد'),
        TextColumn::make('description')->label('الوصف '),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
