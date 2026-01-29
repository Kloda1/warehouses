<?php




namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use App\Enums\BillStatus;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditBill extends EditRecord
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('add_items')
                ->label('➕ إضافة/تعديل مواد')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary')
                ->url(fn () => BillResource::getUrl('items', ['record' => $this->record->id])), // غير 'add-items' إلى 'items'
                
            Actions\Action::make('approve')
                ->label('اعتماد')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->visible(fn() => $this->record->status === BillStatus::DRAFT->value)
                ->action(function () {
                    $this->record->update([
                        'status' => BillStatus::COMPLETED->value,
                        'approved_by' => filament()->auth()->id(),
                        'approved_at' => now(),
                    ]);

                    Notification::make()
                        ->title('تم اعتماد المذكرة بنجاح')
                        ->success()
                        ->send();
                })
                ->requiresConfirmation()
                ->modalHeading('اعتماد المذكرة')
                ->modalDescription('هل أنت متأكد من اعتماد هذه المذكرة؟')
                ->modalSubmitActionLabel('نعم، اعتمد')
                ->modalCancelActionLabel('إلغاء'),

            Actions\DeleteAction::make()
                ->modalHeading('حذف المذكرة')
                ->modalDescription('هل أنت متأكد من حذف هذه المذكرة؟')
                ->modalSubmitActionLabel('نعم، احذف')
                ->modalCancelActionLabel('إلغاء'),
        ];
    }
}

// namespace App\Filament\Resources\BillResource\Pages;

// use App\Filament\Resources\BillResource;
// use Filament\Actions;
// use Filament\Resources\Pages\EditRecord;
// use Filament\Forms;
// use Filament\Forms\Form;
// use Filament\Notifications\Notification;
// use App\Models\Warehouse;
// use App\Enums\BillType;
// use App\Enums\BillStatus;

// class EditBill extends EditRecord
// {
//     protected static string $resource = BillResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             Actions\Action::make('add_items')
//                 ->label('➕ إضافة/تعديل مواد')
//                 ->icon('heroicon-o-shopping-cart')
//                 ->color('primary')
//                 ->url(fn () => BillResource::getUrl('add-items', ['record' => $this->record->id])),
                
//             Actions\Action::make('approve')
//                 ->label('اعتماد')
//                 ->icon('heroicon-o-check-circle')
//                 ->color('success')
//                 ->visible(fn() => $this->record->status === BillStatus::DRAFT->value)
//                 ->action(function () {
//                     $this->record->update([
//                         'status' => BillStatus::COMPLETED->value,
//                         'approved_by' => filament()->auth()->id(),
//                         'approved_at' => now(),
//                     ]);
                    
//                     Notification::make()
//                         ->title('تم اعتماد المذكرة بنجاح')
//                         ->success()
//                         ->send();
                    
//                     $this->refreshFormData(['status']);
//                 })
//                 ->requiresConfirmation()
//                 ->modalHeading('اعتماد المذكرة')
//                 ->modalDescription('هل أنت متأكد من اعتماد هذه المذكرة؟')
//                 ->modalSubmitActionLabel('نعم، اعتمد')
//                 ->modalCancelActionLabel('إلغاء'),
                
//             Actions\DeleteAction::make()
//                 ->modalHeading('حذف المذكرة')
//                 ->modalDescription('هل أنت متأكد من حذف هذه المذكرة؟')
//                 ->modalSubmitActionLabel('نعم، احذف')
//                 ->modalCancelActionLabel('إلغاء'),
//         ];
//     }

//     public function form(Form $form): Form
//     {
//         return $form
//             ->schema([
//                 Forms\Components\Section::make('معلومات المذكرة')
//                     ->description('المعلومات الأساسية للمذكرة')
//                     ->icon('heroicon-o-document')
//                     ->schema([
//                         Forms\Components\Grid::make(4)
//                             ->schema([
//                                 Forms\Components\TextInput::make('bill_number')
//                                     ->label('رقم المذكرة')
//                                     ->required()
//                                     ->disabled(),
                                
//                                 Forms\Components\DatePicker::make('date')
//                                     ->label('تاريخ المذكرة')
//                                     ->required()
//                                     ->displayFormat('d/m/Y'),
                                
//                                 Forms\Components\Select::make('type')
//                                     ->label('نوع المذكرة')
//                                     ->required()
//                                     ->options([
//                                         BillType::PURCHASE->value => 'شراء',
//                                         BillType::TRANSFER->value => 'تحويل',
//                                         BillType::ADJUSTMENT->value => 'تعديل',
//                                         BillType::RETURN->value => 'مرتجع',
//                                     ])
//                                     ->disabled(),
                                
//                                 Forms\Components\Select::make('status')
//                                     ->label('حالة المذكرة')
//                                     ->required()
//                                     ->options([
//                                         BillStatus::DRAFT->value => 'مسودة',
//                                         'pending' => 'معلقة',
//                                         BillStatus::COMPLETED->value => 'مكتملة',
//                                         'cancelled' => 'ملغاة',
//                                     ]),
//                             ]),
                        
//                         Forms\Components\Grid::make(2)
//                             ->schema([
//                                 Forms\Components\Select::make('supplier_id')
//                                     ->label('المورد')
//                                     ->searchable()
//                                     ->preload()
//                                     ->nullable()
//                                     ->visible(fn ($get) => in_array($get('type'), [
//                                         BillType::PURCHASE->value, 
//                                         BillType::RETURN->value
//                                     ])),
                                
//                                 Forms\Components\TextInput::make('party_name')
//                                     ->label('اسم الطرف')
//                                     ->placeholder('أدخل اسم الطرف يدوياً')
//                                     ->maxLength(255)
//                                     ->nullable(),
//                             ]),
                        
//                         Forms\Components\Grid::make(2)
//                             ->schema([
//                                 Forms\Components\Select::make('source_warehouse_id')
//                                     ->label('المستودع المصدر')
//                                     ->options(fn () => Warehouse::active()->pluck('name', 'id'))
//                                     ->searchable()
//                                     ->preload()
//                                     ->nullable()
//                                     ->visible(fn ($get) => in_array($get('type'), [
//                                         BillType::TRANSFER->value,
//                                         BillType::ADJUSTMENT->value,
//                                         BillType::RETURN->value,
//                                     ])),
                                
//                                 Forms\Components\Select::make('destination_warehouse_id')
//                                     ->label('المستودع الوجهة')
//                                     ->options(fn () => Warehouse::active()->pluck('name', 'id'))
//                                     ->searchable()
//                                     ->preload()
//                                     ->nullable()
//                                     ->visible(fn ($get) => in_array($get('type'), [
//                                         BillType::PURCHASE->value,
//                                         BillType::TRANSFER->value,
//                                         BillType::ADJUSTMENT->value,
//                                         BillType::RETURN->value,
//                                     ])),
//                             ]),
                        
//                         Forms\Components\Grid::make(2)
//                             ->schema([
//                                 Forms\Components\TextInput::make('reference_number')
//                                     ->label('رقم المرجع')
//                                     ->placeholder('رقم المرجع')
//                                     ->maxLength(255)
//                                     ->nullable(),
                                
//                                 Forms\Components\DatePicker::make('reference_date')
//                                     ->label('تاريخ المرجع')
//                                     ->displayFormat('d/m/Y')
//                                     ->nullable(),
//                             ]),
                        
//                         Forms\Components\Textarea::make('notes')
//                             ->label('ملاحظات')
//                             ->placeholder('أي ملاحظات إضافية حول المذكرة...')
//                             ->rows(2)
//                             ->columnSpanFull(),
//                     ])
//                     ->collapsible(),
                
//                 Forms\Components\Section::make('المواد المضافة')
//                     ->description('المواد المضافة للمذكرة')
//                     ->icon('heroicon-o-shopping-cart')
//                     ->schema([
//                         Forms\Components\Repeater::make('billRecords')
//                             ->relationship('billRecords')
//                             ->schema([
//                                 Forms\Components\Grid::make(5)
//                                     ->schema([
//                                         Forms\Components\Select::make('item_id')
//                                             ->label('الصنف')
//                                             ->options(fn () => \App\Models\Item::active()->pluck('name', 'id'))
//                                             ->searchable()
//                                             ->preload()
//                                             ->required()
//                                             ->disabled(),
                                        
//                                         Forms\Components\TextInput::make('quantity')
//                                             ->label('الكمية')
//                                             ->numeric()
//                                             ->required()
//                                             ->disabled(),
                                        
//                                         Forms\Components\TextInput::make('unit_price')
//                                             ->label('سعر الوحدة')
//                                             ->numeric()
//                                             ->required()
//                                             ->disabled(),
                                        
//                                         Forms\Components\TextInput::make('total_price')
//                                             ->label('الإجمالي')
//                                             ->numeric()
//                                             ->disabled()
//                                             ->default(fn ($get) => ($get('quantity') ?? 0) * ($get('unit_price') ?? 0)),
                                        
//                                         Forms\Components\TextInput::make('batch_number')
//                                             ->label('رقم الدفعة')
//                                             ->disabled(),
//                                     ]),
//                             ])
//                             ->defaultItems(0)
//                             ->disabled()
//                             ->dehydrated(false)
//                             ->columnSpanFull(),
//                     ])
//                     ->collapsible()
//                     ->visible(fn () => $this->record->billRecords()->count() > 0),
                
//                 Forms\Components\Section::make('الحسابات')
//                     ->description('حسابات المذكرة النهائية')
//                     ->icon('heroicon-o-calculator')
//                     ->schema([
//                         Forms\Components\Grid::make(3)
//                             ->schema([
//                                 Forms\Components\TextInput::make('subtotal')
//                                     ->label('المجموع الفرعي')
//                                     ->numeric()
//                                     ->disabled()
//                                     ->dehydrated(),
                                
//                                 Forms\Components\TextInput::make('discount')
//                                     ->label('الخصم')
//                                     ->numeric()
//                                     ->minValue(0)
//                                     ->reactive()
//                                     ->afterStateUpdated(function ($state, callable $set, $get) {
//                                         $subtotal = $get('subtotal') ?? 0;
//                                         $tax = $get('tax') ?? 0;
//                                         $total = $subtotal - $state + $tax;
//                                         $set('total', $total);
//                                     }),
                                
//                                 Forms\Components\TextInput::make('tax')
//                                     ->label('الضريبة')
//                                     ->numeric()
//                                     ->minValue(0)
//                                     ->reactive()
//                                     ->afterStateUpdated(function ($state, callable $set, $get) {
//                                         $subtotal = $get('subtotal') ?? 0;
//                                         $discount = $get('discount') ?? 0;
//                                         $total = $subtotal - $discount + $state;
//                                         $set('total', $total);
//                                     }),
//                             ]),
                        
//                         Forms\Components\TextInput::make('total')
//                             ->label('الإجمالي النهائي')
//                             ->numeric()
//                             ->disabled()
//                             ->dehydrated()
//                             ->columnSpanFull(),
                        
//                         Forms\Components\Placeholder::make('summary')
//                             ->label('ملخص المذكرة')
//                             ->content(function ($get) {
//                                 $subtotal = $get('subtotal') ?? 0;
//                                 $discount = $get('discount') ?? 0;
//                                 $tax = $get('tax') ?? 0;
//                                 $total = $get('total') ?? 0;
                                
//                                 return "المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
//                             })
//                             ->columnSpanFull(),
//                     ])
//                     ->collapsible(),
//             ]);
//     }
// }