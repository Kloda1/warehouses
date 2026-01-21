<?php

namespace App\Filament\Resources\GoodsReceiptNotes\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\HtmlString;
use Filament\Schemas\Components\Section;
// use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use App\Models\GoodsReceiptNote;

class GoodsReceiptNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema(
                components: [
                TextInput::make('memo_number')
                    ->label('رقم المذكرة')
                    ->required()
                    ->numeric()
                    ->maxlength(50)
                    ->default(fn () => (GoodsReceiptNote::max('memo_number') ?? 0) + 1)
                    ->disabled()
                    ->dehydrated(),
                TextInput::make('order_number')
                    ->label('رقم الطلب')
                    ->required()
                    ->numeric()
                    ->maxlength(50),

                TextInput::make('folder_number')
                    ->label('رقم المجلد')
                    ->required()
                    ->numeric()
                    ->maxlength(50),

                TextInput::make('bill_number')
                    ->label('رقم الفاتورة')
                    ->required()
                    ->numeric()
                    ->maxlength(50),

                DatePicker::make('date')
                    ->label(' التاريخ')
                    ->required(),

                TextInput::make('financial_memo_number')
                    ->label('رقم المذكرة المالي')
                    ->required()
                    ->numeric()
                    ->maxlength(50),

                DatePicker::make('bill_date')
                    ->label('تاريخ الفاتورة')
                    ->required(),

                DatePicker::make('order_date')
                    ->label('تاريخ الطلب')
                    ->required(),

                Textarea::make('description')
                    ->label( 'اضافة ملاحظة ')
                    ->nullable()
                    ->maxlength(100),

                Select::make('deliver')
                ->label('اسم المورد')
                ->searchable()
                ->options([
                    'ali'
                ])->native(false)
                ->required()

            ])->columns(3);
        
    }
}