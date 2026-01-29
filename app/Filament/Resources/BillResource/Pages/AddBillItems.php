<?php
/*
namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use App\Models\Bill;
use App\Models\Item;
use App\Models\BillRecord;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class AddBillItems extends Page
{

protected static ?string $slug = '{record}/items';


    protected static string $resource = BillResource::class;
    protected static string $view = 'filament.resources.bill-resource.pages.add-bill-items';
    
    public Bill $record;
    public $items = [];

    public function mount($record): void
    {
        $this->record = Bill::findOrFail($record);
        
        // تحقق إذا كان هناك مواد مضافة مسبقاً
        $existingItems = $this->record->billRecords()->with('item')->get();
        
        if ($existingItems->count() > 0) {
            foreach ($existingItems as $item) {
                $this->items[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->quantity * $item->unit_price,
                    'batch_number' => $item->batch_number ?? '',
                ];
            }
        } else {
            for ($i = 0; $i < 3; $i++) {
                $this->items[] = [
                    'item_id' => null,
                    'quantity' => 1,
                    'unit_price' => 0,
                    'total_price' => 0,
                    'batch_number' => '',
                ];
            }
        }
    }

    // غير هذه الدالة لتُرجع array بدل Form
    public function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('المرحلة 2: إضافة المواد للمذكرة')
                ->description('أضف المواد للمذكرة #' . $this->record->bill_number)
                ->icon('heroicon-o-shopping-cart')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->label('المواد')
                        ->schema([
                            Forms\Components\Grid::make(5)
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
                                                $set('unit_price', $item->sale_price ?? 0);
                                            }
                                        }),
                                    
                                    Forms\Components\TextInput::make('quantity')
                                        ->label('الكمية')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0.01)
                                        ->step(0.01)
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set, $get) {
                                            $unitPrice = $get('unit_price') ?? 0;
                                            $set('total_price', $unitPrice * $state);
                                        }),
                                    
                                    Forms\Components\TextInput::make('unit_price')
                                        ->label('سعر الوحدة')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->step(0.01)
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set, $get) {
                                            $quantity = $get('quantity') ?? 0;
                                            $set('total_price', $state * $quantity);
                                        }),
                                    
                                    Forms\Components\TextInput::make('total_price')
                                        ->label('الإجمالي')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated(false),
                                    
                                    Forms\Components\TextInput::make('batch_number')
                                        ->label('رقم الدفعة')
                                        ->placeholder('اختياري'),
                                ]),
                        ])
                        ->defaultItems(count($this->items))
                        ->reorderable(true)
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(fn (array $state): ?string => 
                            isset($state['item_id']) ? Item::find($state['item_id'])?->name : 'صنف جديد'
                        )
                        ->columnSpanFull(),
                    
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('discount')
                                ->label('الخصم')
                                ->numeric()
                                ->default($this->record->discount ?? 0)
                                ->minValue(0),
                            
                            Forms\Components\TextInput::make('tax')
                                ->label('الضريبة')
                                ->numeric()
                                ->default($this->record->tax ?? 0)
                                ->minValue(0),
                        ]),
                    
                    Forms\Components\Placeholder::make('summary')
                        ->label('ملخص المذكرة')
                        ->content(function ($get) {
                            $items = $get('items') ?? [];
                            $subtotal = 0;
                            
                            foreach ($items as $item) {
                                if (isset($item['quantity']) && isset($item['unit_price'])) {
                                    $subtotal += ($item['quantity'] * $item['unit_price']);
                                }
                            }
                            
                            $discount = $get('discount') ?? 0;
                            $tax = $get('tax') ?? 0;
                            $total = $subtotal - $discount + $tax;
                            
                            return "عدد الأصناف: " . count($items) . " | المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
                        })
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_bill')
                ->label('العودة للمذكرة')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => BillResource::getUrl('edit', ['record' => $this->record->id]))
                ->color('gray'),
                
            Actions\Action::make('save_and_finish')
                ->label('💾 حفظ المواد وإنهاء')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function (array $data) {
                    DB::transaction(function () use ($data) {
                        // حذف المواد القديمة أولاً
                        BillRecord::where('bill_id', $this->record->id)->delete();
                        
                        // إضافة المواد الجديدة
                        $subtotal = 0;
                        foreach ($data['items'] as $itemData) {
                            if (!empty($itemData['item_id'])) {
                                BillRecord::create([
                                    'bill_id' => $this->record->id,
                                    'item_id' => $itemData['item_id'],
                                    'quantity' => $itemData['quantity'],
                                    'unit_price' => $itemData['unit_price'],
                                    'batch_number' => $itemData['batch_number'] ?? null,
                                ]);
                                
                                $subtotal += ($itemData['quantity'] * $itemData['unit_price']);
                            }
                        }
                        
                        // تحديث الفاتورة
                        $this->record->update([
                            'subtotal' => $subtotal,
                            'discount' => $data['discount'] ?? 0,
                            'tax' => $data['tax'] ?? 0,
                            'total' => $subtotal - ($data['discount'] ?? 0) + ($data['tax'] ?? 0),
                        ]);
                        
                        Notification::make()
                            ->title('تم حفظ المواد بنجاح')
                            ->success()
                            ->send();
                    });
                    
                     return redirect(BillResource::getUrl('view', ['record' => $this->record->id]));
                })
                ->requiresConfirmation()
                ->modalHeading('حفظ المواد')
                ->modalDescription('هل أنت متأكد من حفظ المواد وإنهاء العملية؟')
                ->modalSubmitActionLabel('نعم، احفظ وأنهي')
                ->modalCancelActionLabel('إلغاء'),
        ];
    }

    public function getBillRecords()
    {
        return $this->record->billRecords()->with('item')->get();
    }
}*/


 

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use App\Models\Bill;
use App\Models\Item;
use App\Models\BillRecord;
use Filament\Forms;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Filament\Forms\Form; 


class AddBillItems extends Page implements HasForms
{
    use InteractsWithForms;
    
    protected static ?string $slug = '{record}/items';
    protected static string $resource = BillResource::class;
    protected static string $view = 'filament.resources.bill-resource.pages.add-bill-items';
    
    public Bill $bill;
    public array $data = [];

    public function mount($record): void
    {
        $this->bill = Bill::findOrFail($record);
        
         
        $existingItems = $this->bill->billRecords()->with('item')->get();
        
        $formData = [];
        
        if ($existingItems->count() > 0) {
            $itemsArray = [];
            foreach ($existingItems as $item) {
                $itemsArray[] = [
                    'item_id' => $item->item_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'batch_number' => $item->batch_number ?? '',
                ];
            }
            
            $formData['items'] = $itemsArray;
        } else {
            $itemsArray = [];
            for ($i = 0; $i < 3; $i++) {
                $itemsArray[] = [
                    'item_id' => null,
                    'quantity' => 1,
                    'unit_price' => 0,
                    'batch_number' => '',
                ];
            }
            
            $formData['items'] = $itemsArray;
        }
        
        $formData['discount'] = $this->bill->discount ?? 0;
        $formData['tax'] = $this->bill->tax ?? 0;
        
         $this->form->fill($formData);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema($this->getFormSchema())
            ->statePath('data');
    }

    protected function getFormSchema(): array
    {
        return [
            Forms\Components\Section::make('المرحلة 2: إضافة المواد للمذكرة')
                ->description('أضف المواد للمذكرة #' . $this->bill->bill_number)
                ->icon('heroicon-o-shopping-cart')
                ->schema([
                    Forms\Components\Repeater::make('items')
                        ->label('المواد')
                        ->schema([
                            Forms\Components\Grid::make(5)
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
                                                $set('unit_price', $item->sale_price ?? 0);
                                            }
                                        }),
                                    
                                    Forms\Components\TextInput::make('quantity')
                                        ->label('الكمية')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0.01)
                                        ->step(0.01)
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set, $get) {
                                            $unitPrice = $get('unit_price') ?? 0;
                                            $set('total_price', $unitPrice * $state);
                                        }),
                                    
                                    Forms\Components\TextInput::make('unit_price')
                                        ->label('سعر الوحدة')
                                        ->numeric()
                                        ->required()
                                        ->minValue(0)
                                        ->step(0.01)
                                        ->live()
                                        ->afterStateUpdated(function ($state, callable $set, $get) {
                                            $quantity = $get('quantity') ?? 0;
                                            $set('total_price', $state * $quantity);
                                        }),
                                    
                                    Forms\Components\TextInput::make('total_price')
                                        ->label('الإجمالي')
                                        ->numeric()
                                        ->disabled()
                                        ->dehydrated(),
                                    
                                    Forms\Components\TextInput::make('batch_number')
                                        ->label('رقم الدفعة')
                                        ->placeholder('اختياري'),
                                ]),
                        ])
                        ->reorderable(true)
                        ->collapsible()
                        ->cloneable()
                        ->itemLabel(fn (array $state): ?string => 
                            isset($state['item_id']) ? Item::find($state['item_id'])?->name : 'صنف جديد'
                        )
                        ->columnSpanFull(),
                    
                    Forms\Components\Grid::make(2)
                        ->schema([
                            Forms\Components\TextInput::make('discount')
                                ->label('الخصم')
                                ->numeric()
                                ->minValue(0),
                            
                            Forms\Components\TextInput::make('tax')
                                ->label('الضريبة')
                                ->numeric()
                                ->minValue(0),
                        ]),
                    
                    Forms\Components\Placeholder::make('summary')
                        ->label('ملخص المذكرة')
                        ->content(function ($get) {
                            $items = $get('items') ?? [];
                            $subtotal = 0;
                            
                            foreach ($items as $item) {
                                if (isset($item['quantity']) && isset($item['unit_price'])) {
                                    $subtotal += ($item['quantity'] * $item['unit_price']);
                                }
                            }
                            
                            $discount = $get('discount') ?? 0;
                            $tax = $get('tax') ?? 0;
                            $total = $subtotal - $discount + $tax;
                            
                            return "عدد الأصناف: " . count($items) . " | المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
                        })
                        ->columnSpanFull(),
                ])
                ->columns(1),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back_to_bill')
                ->label('العودة للمذكرة')
                ->icon('heroicon-o-arrow-left')
                ->url(fn () => BillResource::getUrl('edit', ['record' => $this->bill->id]))
                ->color('gray'),
                
     Actions\Action::make('save_and_finish')
                ->label('💾 حفظ المواد وإنهاء')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->action(function () {
                    $data = $this->form->getState();
                    
                    DB::transaction(function () use ($data) {
                        BillRecord::where('bill_id', $this->bill->id)->delete();
                        
                        $subtotal = 0;
                        foreach ($data['items'] as $itemData) {
                            if (!empty($itemData['item_id'])) {
                                BillRecord::create([
                                    'bill_id' => $this->bill->id,
                                    'item_id' => $itemData['item_id'],
                                    'quantity' => $itemData['quantity'],
                                    'unit_price' => $itemData['unit_price'],
                                    'batch_number' => $itemData['batch_number'] ?? null,
                                ]);
                                
                                $subtotal += ($itemData['quantity'] * $itemData['unit_price']);
                            }
                        }
                        
                        $this->bill->update([
                            'subtotal' => $subtotal,
                            'discount' => $data['discount'] ?? 0,
                            'tax' => $data['tax'] ?? 0,
                            'total' => $subtotal - ($data['discount'] ?? 0) + ($data['tax'] ?? 0),
                        ]);
                        
                        Notification::make()
                            ->title('تم حفظ المواد بنجاح')
                            ->success()
                            ->send();
                    });
                    
                    return redirect(BillResource::getUrl('view', ['record' => $this->bill->id]));
                })
                ->requiresConfirmation()
                ->modalHeading('حفظ المواد')
                ->modalDescription('هل أنت متأكد من حفظ المواد وإنهاء العملية؟')
                ->modalSubmitActionLabel('نعم، احفظ وأنهي')
                ->modalCancelActionLabel('إلغاء'),
        ];
    }

    public function getBillRecords()
    {
        return $this->bill->billRecords()->with('item')->get();
    }
}