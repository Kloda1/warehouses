<?php

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use App\Models\Bill;
use App\Models\Item;
use App\Models\BillRecord;
use App\Models\Warehouse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class ManageBillItems extends Page
{
    public Bill $record;
    
    protected static string $resource = BillResource::class;
    protected static string $view = 'filament.resources.bill-resource.pages.manage-bill-items';

    public function mount($record): void
    {
        $this->record = Bill::findOrFail($record);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
          
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_bill')
                ->label('العودة للمذكرة')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => BillResource::getUrl('edit', ['record' => $this->record->id]))
                ->color('gray'),
                
            Actions\Action::make('add_item')
                ->label('➕ إضافة صنف جديد')
                ->icon('heroicon-o-plus')
                ->color('primary')
                ->modalHeading('إضافة صنف إلى المذكرة')
                ->modalSubmitActionLabel('إضافة')
                ->modalCancelActionLabel('إلغاء')
                ->form([
                    Forms\Components\Grid::make(3)
                        ->schema([
                            Forms\Components\Select::make('item_id')
                                ->label('الصنف')
                                ->options(fn () => Item::active()->pluck('name', 'id'))
                                ->searchable()
                                ->preload()
                                ->required()
                                ->live()
                                ->columnSpan(2)
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($item = Item::find($state)) {
                                        $set('unit_price', $item->sale_price);
                                    }
                                }),
                            
                            Forms\Components\TextInput::make('item_code')
                                ->label('كود الصنف')
                                ->disabled()
                                ->dehydrated(false),
                        ]),
                    
                    Forms\Components\Grid::make(4)
                        ->schema([
                            Forms\Components\TextInput::make('quantity')
                                ->label('الكمية')
                                ->numeric()
                                ->required()
                                ->minValue(0.01)
                                ->step(0.01)
                                ->live()
                                ->columnSpan(1)
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $unitPrice = $get('unit_price') ?? 0;
                                    $quantity = $state ?? 0;
                                    $set('total_price', $unitPrice * $quantity);
                                }),
                            
                            Forms\Components\TextInput::make('unit_price')
                                ->label('سعر الوحدة')
                                ->numeric()
                                ->required()
                                ->minValue(0)
                                ->step(0.01)
                                ->live()
                                ->columnSpan(1)
                                ->afterStateUpdated(function ($state, callable $set, $get) {
                                    $quantity = $get('quantity') ?? 0;
                                    $set('total_price', $state * $quantity);
                                }),
                            
                            Forms\Components\TextInput::make('total_price')
                                ->label('الإجمالي')
                                ->numeric()
                                ->disabled()
                                ->dehydrated(false)
                                ->columnSpan(1),
                            
                            Forms\Components\TextInput::make('batch_number')
                                ->label('رقم الدفعة')
                                ->placeholder('اختياري')
                                ->columnSpan(1),
                        ]),
                    
                    Forms\Components\Select::make('warehouse_id')
                        ->label('المستودع')
                        ->options(fn () => Warehouse::active()->pluck('name', 'id'))
                        ->searchable()
                        ->preload()
                        ->nullable()
                        ->visible(fn () => $this->record->type === \App\Enums\BillType::TRANSFER->value),
                    
                    Forms\Components\Textarea::make('notes')
                        ->label('ملاحظات على الصنف')
                        ->placeholder('ملاحظات خاصة بهذا الصنف...')
                        ->rows(2)
                        ->columnSpanFull(),
                ])
                ->action(function (array $data) {
                    DB::transaction(function () use ($data) {
                     
                        BillRecord::create([
                            'bill_id' => $this->record->id,
                            'item_id' => $data['item_id'],
                            'warehouse_id' => $data['warehouse_id'] ?? null,
                            'quantity' => $data['quantity'],
                            'unit_price' => $data['unit_price'],
                            'batch_number' => $data['batch_number'] ?? null,
                            'notes' => $data['notes'] ?? null,
                        ]);
                        
                   
                        $this->updateBillTotals();
                        
                        Notification::make()
                            ->title('تمت إضافة الصنف بنجاح')
                            ->success()
                            ->send();
                    });
                }),
        ];
    }

    public function deleteItem($itemId)
    {
        DB::transaction(function () use ($itemId) {
            BillRecord::where('id', $itemId)->delete();
            
            $this->updateBillTotals();
            
            Notification::make()
                ->title('تم حذف الصنف بنجاح')
                ->success()
                ->send();
        });
    }

    private function updateBillTotals(): void
    {
        $subtotal = $this->record->billRecords()->sum(DB::raw('quantity * unit_price'));
        
        $this->record->update([
            'subtotal' => $subtotal,
            'total' => $subtotal - ($this->record->discount ?? 0) + ($this->record->tax ?? 0),
        ]);
        
        $this->record->refresh();
    }

    public function getBillItems()
    {
        return $this->record->billRecords()->with('item')->get();
    }

    public function getTotal()
    {
        return $this->record->total;
    }

    public function getSubtotal()
    {
        return $this->record->subtotal;
    }
}