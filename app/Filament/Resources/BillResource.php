<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Models\Bill;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Item;
use App\Models\BillRecord;
use App\Enums\BillType;
use App\Enums\BillStatus;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Closure;




class BillResource extends Resource
{

    protected static ?string $model = Bill::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'المذكرات';
    protected static ?string $modelLabel = 'مذكرة';
    protected static ?string $pluralModelLabel = 'المذكرات';
    protected static ?string $activeNavigationIcon = 'heroicon-o-chevron-double-down';

    protected static ?int $navigationSort = 2;


    // protected static ?string $navigationGroup = 'المخزون';
    public static function form(Form $form): Form
    {
        return $form;
        // ->schema([
        //     Forms\Components\Section::make('معلومات المذكرة')
        //         ->description('المعلومات الأساسية للمذكرة')
        //         ->icon('heroicon-o-document')
        //         ->schema([
        //             Forms\Components\Grid::make(4)
        //                 ->schema([
        //                     Forms\Components\TextInput::make('bill_number')
        //                         ->label('رقم المذكرة')
        //                         ->required()
        //                         ->unique(ignoreRecord: true)
        //                         ->default(fn () => 'MEMO-' . (Bill::count() + 1))
        //                         ->disabled(fn ($operation) => $operation === 'edit'),

        //                     Forms\Components\DatePicker::make('date')
        //                         ->label('تاريخ المذكرة')
        //                         ->required()
        //                         ->default(now())
        //                         ->displayFormat('d/m/Y'),

        //                     Forms\Components\Select::make('type')
        //                         ->label('نوع المذكرة')
        //                         ->required()
        //                         ->options([
        //                             BillType::PURCHASE->value => 'شراء',
        //                             BillType::TRANSFER->value => 'تحويل',
        //                             BillType::ADJUSTMENT->value => 'تعديل',
        //                             BillType::RETURN->value => 'مرتجع',
        //                         ])
        //                         ->default(BillType::PURCHASE->value)
        //                         ->live(),

        //                     Forms\Components\Select::make('status')
        //                         ->label('حالة المذكرة')
        //                         ->required()
        //                         ->options([
        //                             BillStatus::DRAFT->value => 'مسودة',
        //                             'pending' => 'معلقة',
        //                             BillStatus::COMPLETED->value => 'مكتملة',
        //                             'cancelled' => 'ملغاة',
        //                         ])
        //                         ->default(BillStatus::DRAFT->value),
        //                 ]),

        //             Forms\Components\Grid::make(2)
        //                 ->schema([
        //                     Forms\Components\Select::make('supplier_id')
        //                         ->label('المورد')
        //                         ->searchable()
        //                         ->preload()
        //                         ->nullable()
        //                         ->visible(fn ($get) => in_array($get('type'), [
        //                             BillType::PURCHASE->value, 
        //                             BillType::RETURN->value
        //                         ])),

        //                     Forms\Components\TextInput::make('party_name')
        //                         ->label('اسم الطرف')
        //                         ->placeholder('أدخل اسم الطرف يدوياً')
        //                         ->maxLength(255)
        //                         ->nullable(),
        //                 ]),

        //             Forms\Components\Grid::make(2)
        //                 ->schema([
        //                     Forms\Components\Select::make('source_warehouse_id')
        //                         ->label('المستودع المصدر')
        //                         ->options(fn () => Warehouse::active()->pluck('name', 'id'))
        //                         ->searchable()
        //                         ->preload()
        //                         ->nullable()
        //                         ->visible(fn ($get) => in_array($get('type'), [
        //                             BillType::TRANSFER->value,
        //                             BillType::ADJUSTMENT->value,
        //                             BillType::RETURN->value,
        //                         ])),

        //                     Forms\Components\Select::make('destination_warehouse_id')
        //                         ->label('المستودع الوجهة')
        //                         ->options(fn () => Warehouse::active()->pluck('name', 'id'))
        //                         ->searchable()
        //                         ->preload()
        //                         ->nullable()
        //                         ->visible(fn ($get) => in_array($get('type'), [
        //                             BillType::PURCHASE->value,
        //                             BillType::TRANSFER->value,
        //                             BillType::ADJUSTMENT->value,
        //                             BillType::RETURN->value,
        //                         ])),
        //                 ]),

        //             Forms\Components\Grid::make(2)
        //                 ->schema([
        //                     Forms\Components\TextInput::make('reference_number')
        //                         ->label('رقم المرجع')
        //                         ->placeholder('رقم المرجع')
        //                         ->maxLength(255)
        //                         ->nullable(),

        //                     Forms\Components\DatePicker::make('reference_date')
        //                         ->label('تاريخ المرجع')
        //                         ->displayFormat('d/m/Y')
        //                         ->nullable(),
        //                 ]),

        //             Forms\Components\Textarea::make('notes')
        //                 ->label('ملاحظات')
        //                 ->placeholder('أي ملاحظات إضافية حول المذكرة...')
        //                 ->rows(2)
        //                 ->columnSpanFull(),
        //         ])
        //         ->collapsible(),

        //     Forms\Components\Section::make('الحسابات')
        //         ->description('حسابات المذكرة النهائية')
        //         ->icon('heroicon-o-calculator')
        //         ->schema([
        //             Forms\Components\Grid::make(3)
        //                 ->schema([
        //                     Forms\Components\TextInput::make('subtotal')
        //                         ->label('المجموع الفرعي')
        //                         ->numeric()
        //                         ->default(0)
        //                         ->disabled()
        //                         ->dehydrated()
        //                         ->helperText('يتم حسابه تلقائياً من المواد'),

        //                     Forms\Components\TextInput::make('discount')
        //                         ->label('الخصم')
        //                         ->numeric()
        //                         ->default(0)
        //                         ->minValue(0)
        //                         ->reactive()
        //                         ->afterStateUpdated(function ($state, callable $set, $get) {
        //                             $subtotal = $get('subtotal') ?? 0;
        //                             $tax = $get('tax') ?? 0;
        //                             $total = $subtotal - $state + $tax;
        //                             $set('total', $total);
        //                         }),

        //                     Forms\Components\TextInput::make('tax')
        //                         ->label('الضريبة')
        //                         ->numeric()
        //                         ->default(0)
        //                         ->minValue(0)
        //                         ->reactive()
        //                         ->afterStateUpdated(function ($state, callable $set, $get) {
        //                             $subtotal = $get('subtotal') ?? 0;
        //                             $discount = $get('discount') ?? 0;
        //                             $total = $subtotal - $discount + $state;
        //                             $set('total', $total);
        //                         }),
        //                 ]),

        //             Forms\Components\TextInput::make('total')
        //                 ->label('الإجمالي النهائي')
        //                 ->numeric()
        //                 ->default(0)
        //                 ->disabled()
        //                 ->dehydrated()
        //                 ->columnSpanFull(),

        //             Forms\Components\Placeholder::make('summary')
        //                 ->label('ملخص المذكرة')
        //                 ->content(function ($record) {
        //                     if (!$record) return 'لم يتم حساب الإجماليات بعد';

        //                     $itemsCount = $record->billRecords()->count();
        //                     $subtotal = $record->subtotal ?? 0;
        //                     $discount = $record->discount ?? 0;
        //                     $tax = $record->tax ?? 0;
        //                     $total = $record->total ?? 0;

        //                     return "عدد الأصناف: {$itemsCount} | المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
        //                 })
        //                 ->columnSpanFull(),
        //         ])
        //         ->collapsible(),

        //     Forms\Components\Hidden::make('created_by')
        //         ->default(filament()->auth()->id()),
        // ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bill_number')
                    ->label('رقم المذكرة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('التاريخ')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('النوع')
                    ->formatStateUsing(fn($state) => match ($state) {
                        BillType::PURCHASE->value => 'شراء',
                        BillType::TRANSFER->value => 'تحويل',
                        BillType::ADJUSTMENT->value => 'تعديل',
                        BillType::RETURN->value => 'مرتجع',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        BillType::PURCHASE->value => 'success',
                        BillType::TRANSFER->value => 'info',
                        BillType::ADJUSTMENT->value => 'warning',
                        BillType::RETURN->value => 'primary',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('party_name')
                    ->label('الطرف')
                    ->searchable()
                    ->limit(25),

                Tables\Columns\TextColumn::make('total')
                    ->label('الإجمالي')
                    ->money('SDG')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('الحالة')
                    ->formatStateUsing(fn($state) => match ($state) {
                        BillStatus::DRAFT->value => 'مسودة',
                        'pending' => 'معلقة',
                        BillStatus::COMPLETED->value => 'مكتملة',
                        'cancelled' => 'ملغاة',
                        default => $state,
                    })
                    ->color(fn($state) => match ($state) {
                        BillStatus::DRAFT->value => 'gray',
                        'pending' => 'warning',
                        BillStatus::COMPLETED->value => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('billRecords_count')
                    ->label('عدد الأصناف')
                    ->counts('billRecords')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('نوع المذكرة')
                    ->options([
                        BillType::PURCHASE->value => 'شراء',
                        BillType::TRANSFER->value => 'تحويل',
                        BillType::ADJUSTMENT->value => 'تعديل',
                        BillType::RETURN->value => 'مرتجع',
                    ])
                    ->placeholder('جميع الأنواع'),

                Tables\Filters\SelectFilter::make('status')
                    ->label('حالة المذكرة')
                    ->options([
                        BillStatus::DRAFT->value => 'مسودة',
                        'pending' => 'معلقة',
                        BillStatus::COMPLETED->value => 'مكتملة',
                        'cancelled' => 'ملغاة',
                    ])
                    ->placeholder('جميع الحالات'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                    Tables\Actions\Action::make('manage_items')
                        ->label('إضافة/تعديل مواد')
                        ->icon('heroicon-o-shopping-cart')
                        ->color('primary')
                        ->url(fn($record) => BillResource::getUrl('items', ['record' => $record]))
                        ->openUrlInNewTab(false),

                    Tables\Actions\Action::make('approve')
                        ->label('اعتماد')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(fn($record) => $record->status === BillStatus::DRAFT->value)
                        ->action(function ($record) {
                            $record->update([
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

                    Tables\Actions\DeleteAction::make()
                        ->modalHeading('حذف المذكرة')
                        ->modalDescription('هل أنت متأكد من حذف هذه المذكرة؟')
                        ->modalSubmitActionLabel('نعم، احذف')
                        ->modalCancelActionLabel('إلغاء'),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->modalHeading('حذف المذكرات المحددة')
                        ->modalDescription('هل أنت متأكد من حذف المذكرات المحددة؟')
                        ->modalSubmitActionLabel('نعم، احذف')
                        ->modalCancelActionLabel('إلغاء'),
                ]),
            ])
            ->defaultSort('date', 'desc')
            ->groups([
                Tables\Grouping\Group::make('type')
                    ->label('حسب النوع')
                    ->collapsible(),

                Tables\Grouping\Group::make('status')
                    ->label('حسب الحالة')
                    ->collapsible(),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getPages(): array
    {
        return [
            // 'index' => Pages\ListBills::route('/'),
            // 'create' => Pages\CreateBill::route('/create'),
            // 'edit' => Pages\EditBill::route('/{record}/edit'),
            // 'view' => Pages\ViewBill::route('/{record}'),
            // 'items' => Pages\ManageBillItems::route('/{record}/items'),  




            'index' => Pages\ListBills::route('/'),
            'create' => Pages\CreateBill::route('/create'),

            'items' => Pages\AddBillItems::route('/{record}/items'),

            'edit' => Pages\EditBill::route('/{record}/edit'),
            'view' => Pages\ViewBill::route('/{record}'),
        ];
    }

    //    public static function form(Form $form): Form
    //     {
    //         return $form
    //             ->schema([
    //                 Forms\Components\Tabs::make('المذكرة')
    //                     ->tabs([
    //                          Forms\Components\Tabs\Tab::make('معلومات المذكرة')
    //                             ->icon('heroicon-o-document')
    //                             ->schema([
    //                                 Forms\Components\Grid::make(4)
    //                                     ->schema([
    //                                         Forms\Components\TextInput::make('bill_number')
    //                                             ->label('رقم المذكرة')
    //                                             ->required()
    //                                             ->unique(ignoreRecord: true)
    //                                             ->default(fn () => 'MEMO-' . (Bill::count() + 1))
    //                                             ->disabled(fn ($operation) => $operation === 'edit'),

    //                                         Forms\Components\DatePicker::make('date')
    //                                             ->label('تاريخ المذكرة')
    //                                             ->required()
    //                                             ->default(now())
    //                                             ->displayFormat('d/m/Y'),

    //                                         Forms\Components\Select::make('type')
    //                                             ->label('نوع المذكرة')
    //                                             ->required()
    //                                             ->options([
    //                                                 BillType::PURCHASE->value => 'شراء',
    //                                                 BillType::TRANSFER->value => 'تحويل',
    //                                                 BillType::ADJUSTMENT->value => 'تعديل',
    //                                                 BillType::RETURN->value => 'مرتجع',
    //                                             ])
    //                                             ->default(BillType::PURCHASE->value)
    //                                             ->live(),

    //                                         Forms\Components\Select::make('status')
    //                                             ->label('حالة المذكرة')
    //                                             ->required()
    //                                             ->options([
    //                                                 BillStatus::DRAFT->value => 'مسودة',
    //                                                 'pending' => 'معلقة',
    //                                                 BillStatus::COMPLETED->value => 'مكتملة',
    //                                                 'cancelled' => 'ملغاة',
    //                                             ])
    //                                             ->default(BillStatus::DRAFT->value),
    //                                     ]),

    //                                 Forms\Components\Grid::make(2)
    //                                     ->schema([
    //                                         Forms\Components\Select::make('supplier_id')
    //                                             ->label('المورد')
    //                                             ->searchable()
    //                                             ->preload()
    //                                             ->nullable()
    //                                             ->visible(fn ($get) => in_array($get('type'), [
    //                                                 BillType::PURCHASE->value, 
    //                                                 BillType::RETURN->value
    //                                             ])),

    //                                         Forms\Components\TextInput::make('party_name')
    //                                             ->label('اسم الطرف')
    //                                             ->placeholder('أدخل اسم الطرف يدوياً')
    //                                             ->maxLength(255)
    //                                             ->nullable(),
    //                                     ]),

    //                                 Forms\Components\Grid::make(2)
    //                                     ->schema([
    //                                         Forms\Components\Select::make('source_warehouse_id')
    //                                             ->label('المستودع المصدر')
    //                                             ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                             ->searchable()
    //                                             ->preload()
    //                                             ->nullable()
    //                                             ->visible(fn ($get) => in_array($get('type'), [
    //                                                 BillType::TRANSFER->value,
    //                                                 BillType::ADJUSTMENT->value,
    //                                                 BillType::RETURN->value,
    //                                             ])),

    //                                         Forms\Components\Select::make('destination_warehouse_id')
    //                                             ->label('المستودع الوجهة')
    //                                             ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                             ->searchable()
    //                                             ->preload()
    //                                             ->nullable()
    //                                             ->visible(fn ($get) => in_array($get('type'), [
    //                                                 BillType::PURCHASE->value,
    //                                                 BillType::TRANSFER->value,
    //                                                 BillType::ADJUSTMENT->value,
    //                                                 BillType::RETURN->value,
    //                                             ])),
    //                                     ]),

    //                                 Forms\Components\Grid::make(2)
    //                                     ->schema([
    //                                         Forms\Components\TextInput::make('reference_number')
    //                                             ->label('رقم المرجع')
    //                                             ->placeholder('رقم المرجع')
    //                                             ->maxLength(255)
    //                                             ->nullable(),

    //                                         Forms\Components\DatePicker::make('reference_date')
    //                                             ->label('تاريخ المرجع')
    //                                             ->displayFormat('d/m/Y')
    //                                             ->nullable(),
    //                                     ]),

    //                                 Forms\Components\Textarea::make('notes')
    //                                     ->label('ملاحظات')
    //                                     ->placeholder('أي ملاحظات إضافية حول المذكرة...')
    //                                     ->rows(2)
    //                                     ->columnSpanFull(),
    //                             ]),

    //                          Forms\Components\Tabs\Tab::make('المواد')
    //                             ->icon('heroicon-o-shopping-cart')
    //                             ->schema([
    //                                 Forms\Components\Actions::make([
    //                                     Forms\Components\Actions\Action::make('add_item')
    //                                         ->label('➕ إضافة صنف جديد')
    //                                         ->icon('heroicon-o-plus')
    //                                         ->color('primary')
    //                                         ->modalHeading('إضافة صنف إلى المذكرة')
    //                                         ->modalSubmitActionLabel('إضافة')
    //                                         ->modalCancelActionLabel('إلغاء')
    //                                         ->form([
    //                                             Forms\Components\Grid::make(3)
    //                                                 ->schema([
    //                                                     Forms\Components\Select::make('item_id')
    //                                                         ->label('الصنف')
    //                                                         ->options(fn () => Item::active()->pluck('name', 'id'))
    //                                                         ->searchable()
    //                                                         ->preload()
    //                                                         ->required()
    //                                                         ->live()
    //                                                         ->columnSpan(2)
    //                                                         ->afterStateUpdated(function ($state, callable $set) {
    //                                                             if ($item = Item::find($state)) {
    //                                                                 $set('unit_price', $item->sale_price);
    //                                                                 $set('item_name', $item->name);
    //                                                                 $set('item_code', $item->code);
    //                                                             }
    //                                                         }),

    //                                                     Forms\Components\TextInput::make('item_code')
    //                                                         ->label('كود الصنف')
    //                                                         ->disabled()
    //                                                         ->dehydrated(false),
    //                                                 ]),

    //                                             Forms\Components\Grid::make(4)
    //                                                 ->schema([
    //                                                     Forms\Components\TextInput::make('quantity')
    //                                                         ->label('الكمية')
    //                                                         ->numeric()
    //                                                         ->required()
    //                                                         ->minValue(0.01)
    //                                                         ->step(0.01)
    //                                                         ->live()
    //                                                         ->columnSpan(1)
    //                                                         ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                             $unitPrice = $get('unit_price') ?? 0;
    //                                                             $quantity = $state ?? 0;
    //                                                             $set('total_price', $unitPrice * $quantity);
    //                                                         }),

    //                                                     Forms\Components\TextInput::make('unit_price')
    //                                                         ->label('سعر الوحدة')
    //                                                         ->numeric()
    //                                                         ->required()
    //                                                         ->minValue(0)
    //                                                         ->step(0.01)
    //                                                         ->live()
    //                                                         ->columnSpan(1)
    //                                                         ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                             $quantity = $get('quantity') ?? 0;
    //                                                             $set('total_price', $state * $quantity);
    //                                                         }),

    //                                                     Forms\Components\TextInput::make('total_price')
    //                                                         ->label('الإجمالي')
    //                                                         ->numeric()
    //                                                         ->disabled()
    //                                                         ->dehydrated(false)
    //                                                         ->columnSpan(1),

    //                                                     Forms\Components\TextInput::make('batch_number')
    //                                                         ->label('رقم الدفعة')
    //                                                         ->placeholder('اختياري')
    //                                                         ->columnSpan(1),
    //                                                 ]),

    //                                             Forms\Components\Select::make('warehouse_id')
    //                                                 ->label('المستودع')
    //                                                 ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                                 ->searchable()
    //                                                 ->preload()
    //                                                 ->nullable()
    //                                                 ->visible(fn ($get, $record) => 
    //                                                     $record && $record->type === BillType::TRANSFER->value
    //                                                 ),

    //                                             Forms\Components\Textarea::make('item_notes')
    //                                                 ->label('ملاحظات على الصنف')
    //                                                 ->placeholder('ملاحظات خاصة بهذا الصنف...')
    //                                                 ->rows(2)
    //                                                 ->columnSpanFull(),
    //                                         ])
    //                                         ->action(function (array $data, Forms\Set $set, Forms\Get $get) {
    //                                             $currentItems = $get('bill_items') ?? [];

    //                                             $newItem = [
    //                                                 'item_id' => $data['item_id'],
    //                                                 'item_name' => Item::find($data['item_id'])->name,
    //                                                 'quantity' => $data['quantity'],
    //                                                 'unit_price' => $data['unit_price'],
    //                                                 'total_price' => $data['quantity'] * $data['unit_price'],
    //                                                 'batch_number' => $data['batch_number'] ?? null,
    //                                                 'warehouse_id' => $data['warehouse_id'] ?? null,
    //                                                 'item_notes' => $data['item_notes'] ?? null,
    //                                             ];

    //                                             $currentItems[] = $newItem;
    //                                             $set('bill_items', $currentItems);

    //                                             $subtotal = 0;
    //                                             foreach ($currentItems as $item) {
    //                                                 $subtotal += ($item['quantity'] * $item['unit_price']);
    //                                             }

    //                                             $set('subtotal', $subtotal);
    //                                             $set('total', $subtotal - ($get('discount') ?? 0) + ($get('tax') ?? 0));

    //                                             Notification::make()
    //                                                 ->title('تمت إضافة الصنف بنجاح')
    //                                                 ->success()
    //                                                 ->send();
    //                                         }),
    //                                 ])->columnSpanFull(),

    //                                 Forms\Components\Repeater::make('bill_items')
    //                                     ->label('المواد المضافة')
    //                                     ->hiddenLabel()
    //                                     ->schema([
    //                                         Forms\Components\Grid::make(6)
    //                                             ->schema([
    //                                                 Forms\Components\TextInput::make('item_name')
    //                                                     ->label('الصنف')
    //                                                     ->disabled()
    //                                                     ->dehydrated(false)
    //                                                     ->columnSpan(2),

    //                                                 Forms\Components\TextInput::make('quantity')
    //                                                     ->label('الكمية')
    //                                                     ->numeric()
    //                                                     ->disabled()
    //                                                     ->dehydrated(false),

    //                                                 Forms\Components\TextInput::make('unit_price')
    //                                                     ->label('سعر الوحدة')
    //                                                     ->numeric()
    //                                                     ->disabled()
    //                                                     ->dehydrated(false),

    //                                                 Forms\Components\TextInput::make('total_price')
    //                                                     ->label('الإجمالي')
    //                                                     ->numeric()
    //                                                     ->disabled()
    //                                                     ->dehydrated(false),

    //                                                 Forms\Components\TextInput::make('batch_number')
    //                                                     ->label('رقم الدفعة')
    //                                                     ->disabled()
    //                                                     ->dehydrated(false),

    //                                                 Forms\Components\Actions::make([
    //                                                     Forms\Components\Actions\Action::make('remove_item')
    //                                                         ->icon('heroicon-o-trash')
    //                                                         ->color('danger')
    //                                                         ->action(function ($state, Forms\Set $set, Forms\Get $get, $index) {
    //                                                             $currentItems = $get('bill_items') ?? [];
    //                                                             unset($currentItems[$index]);
    //                                                             $currentItems = array_values($currentItems);
    //                                                             $set('bill_items', $currentItems);

    //                                                             $subtotal = 0;
    //                                                             foreach ($currentItems as $item) {
    //                                                                 $subtotal += ($item['quantity'] * $item['unit_price']);
    //                                                             }

    //                                                             $set('subtotal', $subtotal);
    //                                                             $set('total', $subtotal - ($get('discount') ?? 0) + ($get('tax') ?? 0));

    //                                                             Notification::make()
    //                                                                 ->title('تم حذف الصنف')
    //                                                                 ->success()
    //                                                                 ->send();
    //                                                         })
    //                                                         ->requiresConfirmation()
    //                                                         ->modalHeading('حذف الصنف')
    //                                                         ->modalDescription('هل أنت متأكد من حذف هذا الصنف من المذكرة؟')
    //                                                         ->modalSubmitActionLabel('نعم، احذف')
    //                                                         ->modalCancelActionLabel('إلغاء'),
    //                                                 ])->columnSpan(1),  // التصحيح هنا
    //                                             ]),
    //                                     ])
    //                                     ->defaultItems(0)
    //                                     ->reorderable(true)
    //                                     ->collapsible()
    //                                     ->itemLabel(fn (array $state): ?string => 
    //                                         $state['item_name'] ?? 'صنف غير معروف'
    //                                     )
    //                                     ->columnSpanFull()
    //                                     ->afterStateUpdated(function ($state, $set, $get) {
    //                                         $subtotal = 0;
    //                                         foreach ($state as $item) {
    //                                             if (isset($item['quantity']) && isset($item['unit_price'])) {
    //                                                 $subtotal += ($item['quantity'] * $item['unit_price']);
    //                                             }
    //                                         }

    //                                         $set('../../subtotal', $subtotal);
    //                                         $set('../../total', $subtotal - ($get('../../discount') ?? 0) + ($get('../../tax') ?? 0));
    //                                     }),
    //                             ]),

    //                          Forms\Components\Tabs\Tab::make('الحسابات')
    //                             ->icon('heroicon-o-calculator')
    //                             ->schema([
    //                                 Forms\Components\Grid::make(3)
    //                                     ->schema([
    //                                         Forms\Components\TextInput::make('subtotal')
    //                                             ->label('المجموع الفرعي')
    //                                             ->numeric()
    //                                             ->default(0)
    //                                             ->disabled()
    //                                             ->dehydrated(),

    //                                         Forms\Components\TextInput::make('discount')
    //                                             ->label('الخصم')
    //                                             ->numeric()
    //                                             ->default(0)
    //                                             ->minValue(0)
    //                                             ->reactive()
    //                                             ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                 $subtotal = $get('subtotal') ?? 0;
    //                                                 $tax = $get('tax') ?? 0;
    //                                                 $total = $subtotal - $state + $tax;
    //                                                 $set('total', $total);
    //                                             }),

    //                                         Forms\Components\TextInput::make('tax')
    //                                             ->label('الضريبة')
    //                                             ->numeric()
    //                                             ->default(0)
    //                                             ->minValue(0)
    //                                             ->reactive()
    //                                             ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                 $subtotal = $get('subtotal') ?? 0;
    //                                                 $discount = $get('discount') ?? 0;
    //                                                 $total = $subtotal - $discount + $state;
    //                                                 $set('total', $total);
    //                                             }),
    //                                     ]),

    //                                 Forms\Components\TextInput::make('total')
    //                                     ->label('الإجمالي النهائي')
    //                                     ->numeric()
    //                                     ->default(0)
    //                                     ->disabled()
    //                                     ->dehydrated()
    //                                     ->columnSpanFull(),

    //                                 Forms\Components\Placeholder::make('summary')
    //                                     ->label('ملخص المذكرة')
    //                                     ->content(function ($get) {
    //                                         $itemsCount = count($get('bill_items') ?? []);
    //                                         $subtotal = $get('subtotal') ?? 0;
    //                                         $discount = $get('discount') ?? 0;
    //                                         $tax = $get('tax') ?? 0;
    //                                         $total = $get('total') ?? 0;

    //                                         return "عدد الأصناف: {$itemsCount} | المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
    //                                     })
    //                                     ->columnSpanFull(),
    //                             ]),
    //                     ])
    //                     ->columnSpanFull(),

    //                 Forms\Components\Hidden::make('created_by')
    //                     ->default(filament()->auth()->id()),
    //             ]);
    //     }

    //     public static function table(Table $table): Table
    //     {
    //         return $table
    //             ->columns([
    //                 Tables\Columns\TextColumn::make('bill_number')
    //                     ->label('رقم المذكرة')
    //                     ->searchable()
    //                     ->sortable(),

    //                 Tables\Columns\TextColumn::make('date')
    //                     ->label('التاريخ')
    //                     ->date('d/m/Y')
    //                     ->sortable(),

    //                 Tables\Columns\BadgeColumn::make('type')
    //                     ->label('النوع')
    //                     ->formatStateUsing(fn ($state) => match($state) {
    //                         BillType::PURCHASE->value => 'شراء',
    //                         BillType::TRANSFER->value => 'تحويل',
    //                         BillType::ADJUSTMENT->value => 'تعديل',
    //                         BillType::RETURN->value => 'مرتجع',
    //                         default => $state,
    //                     })
    //                     ->color(fn ($state) => match($state) {
    //                         BillType::PURCHASE->value => 'success',
    //                         BillType::TRANSFER->value => 'info',
    //                         BillType::ADJUSTMENT->value => 'warning',
    //                         BillType::RETURN->value => 'primary',
    //                         default => 'gray',
    //                     }),

    //                 Tables\Columns\TextColumn::make('party_name')
    //                     ->label('الطرف')
    //                     ->searchable()
    //                     ->limit(25),

    //                 Tables\Columns\TextColumn::make('total')
    //                     ->label('الإجمالي')
    //                     ->money('SDG')
    //                     ->sortable(),

    //                 Tables\Columns\BadgeColumn::make('status')
    //                     ->label('الحالة')
    //                     ->formatStateUsing(fn ($state) => match($state) {
    //                         BillStatus::DRAFT->value => 'مسودة',
    //                         'pending' => 'معلقة',
    //                         BillStatus::COMPLETED->value => 'مكتملة',
    //                         'cancelled' => 'ملغاة',
    //                         default => $state,
    //                     })
    //                     ->color(fn ($state) => match($state) {
    //                         BillStatus::DRAFT->value => 'gray',
    //                         'pending' => 'warning',
    //                         BillStatus::COMPLETED->value => 'success',
    //                         'cancelled' => 'danger',
    //                         default => 'gray',
    //                     }),

    //                 Tables\Columns\TextColumn::make('billRecords_count')
    //                     ->label('عدد الأصناف')
    //                     ->counts('billRecords')
    //                     ->sortable(),
    //             ])
    //             ->filters([
    //                 Tables\Filters\SelectFilter::make('type')
    //                     ->label('نوع المذكرة')
    //                     ->options([
    //                         BillType::PURCHASE->value => 'شراء',
    //                         BillType::TRANSFER->value => 'تحويل',
    //                         BillType::ADJUSTMENT->value => 'تعديل',
    //                         BillType::RETURN->value => 'مرتجع',
    //                     ])
    //                     ->placeholder('جميع الأنواع'),

    //                 Tables\Filters\SelectFilter::make('status')
    //                     ->label('حالة المذكرة')
    //                     ->options([
    //                         BillStatus::DRAFT->value => 'مسودة',
    //                         'pending' => 'معلقة',
    //                         BillStatus::COMPLETED->value => 'مكتملة',
    //                         'cancelled' => 'ملغاة',
    //                     ])
    //                     ->placeholder('جميع الحالات'),
    //             ])
    //             ->actions([
    //                 Tables\Actions\ActionGroup::make([
    //                     Tables\Actions\ViewAction::make(),
    //                     Tables\Actions\EditAction::make(),

    //                     Tables\Actions\Action::make('approve')
    //                         ->label('اعتماد')
    //                         ->icon('heroicon-o-check-circle')
    //                         ->color('success')
    //                         ->visible(fn($record) => $record->status === BillStatus::DRAFT->value)
    //                         ->action(function ($record) {
    //                             $record->update([
    //                                 'status' => BillStatus::COMPLETED->value,
    //                                 'approved_by' => filament()->auth()->id(),
    //                                 'approved_at' => now(),
    //                             ]);

    //                             Notification::make()
    //                                 ->title('تم اعتماد المذكرة بنجاح')
    //                                 ->success()
    //                                 ->send();
    //                         })
    //                         ->requiresConfirmation()
    //                         ->modalHeading('اعتماد المذكرة')
    //                         ->modalDescription('هل أنت متأكد من اعتماد هذه المذكرة؟')
    //                         ->modalSubmitActionLabel('نعم، اعتمد')
    //                         ->modalCancelActionLabel('إلغاء'),

    //                     Tables\Actions\DeleteAction::make()
    //                         ->modalHeading('حذف المذكرة')
    //                         ->modalDescription('هل أنت متأكد من حذف هذه المذكرة؟')
    //                         ->modalSubmitActionLabel('نعم، احذف')
    //                         ->modalCancelActionLabel('إلغاء'),
    //                 ]),
    //             ])
    //             ->bulkActions([
    //                 Tables\Actions\BulkActionGroup::make([
    //                     Tables\Actions\DeleteBulkAction::make()
    //                         ->modalHeading('حذف المذكرات المحددة')
    //                         ->modalDescription('هل أنت متأكد من حذف المذكرات المحددة؟')
    //                         ->modalSubmitActionLabel('نعم، احذف')
    //                         ->modalCancelActionLabel('إلغاء'),
    //                 ]),
    //             ])
    //             ->defaultSort('date', 'desc')
    //             ->groups([
    //                 Tables\Grouping\Group::make('type')
    //                     ->label('حسب النوع')
    //                     ->collapsible(),

    //                 Tables\Grouping\Group::make('status')
    //                     ->label('حسب الحالة')
    //                     ->collapsible(),
    //             ]);
    //     }

    //     public static function getPages(): array
    //     {
    //         return [
    //             'index' => Pages\ListBills::route('/'),
    //             'create' => Pages\CreateBill::route('/create'),
    //             'edit' => Pages\EditBill::route('/{record}/edit'),
    //             'view' => Pages\ViewBill::route('/{record}'),
    //         ];
    //     }


    // public static function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             Forms\Components\Tabs::make('فاتورة')
    //                 ->tabs([
    //                      Forms\Components\Tabs\Tab::make('معلومات الفاتورة')
    //                         ->icon('heroicon-o-document')
    //                         ->schema([
    //                             Forms\Components\Grid::make(4)
    //                                 ->schema([
    //                                     Forms\Components\TextInput::make('bill_number')
    //                                         ->label('رقم الفاتورة')
    //                                         ->required()
    //                                         ->unique(ignoreRecord: true)
    //                                         ->default(fn () => 'BILL-' . (Bill::count() + 1))
    //                                         ->disabled(fn ($operation) => $operation === 'edit'),

    //                                     Forms\Components\DatePicker::make('date')
    //                                         ->label('تاريخ الفاتورة')
    //                                         ->required()
    //                                         ->default(now())
    //                                         ->displayFormat('d/m/Y'),

    //                                     Forms\Components\Select::make('type')
    //                                         ->label('نوع الفاتورة')
    //                                         ->required()
    //                                         ->options([
    //                                             BillType::PURCHASE->value => BillType::PURCHASE->label(),
    //                                             BillType::TRANSFER->value => BillType::TRANSFER->label(),
    //                                             BillType::ADJUSTMENT->value => BillType::ADJUSTMENT->label(),
    //                                             BillType::RETURN->value => BillType::RETURN->label(),
    //                                         ])
    //                                         ->default(BillType::PURCHASE->value)
    //                                         ->live(),

    //                                     Forms\Components\Select::make('status')
    //                                         ->label('حالة الفاتورة')
    //                                         ->required()
    //                                         ->options([
    //                                             BillStatus::DRAFT->value => 'مسودة',
    //                                             'pending' => 'معلقة',
    //                                             BillStatus::COMPLETED->value => 'مكتملة',
    //                                             'cancelled' => 'ملغاة',
    //                                         ])
    //                                         ->default(BillStatus::DRAFT->value),
    //                                 ]),

    //                             Forms\Components\Grid::make(2)
    //                                 ->schema([
    //                                     Forms\Components\Select::make('supplier_id')
    //                                         ->label('المورد')
    //                                         // ->options(fn () => Supplier::active()->pluck('name', 'id'))
    //                                         ->searchable()
    //                                         ->preload()
    //                                         ->nullable()
    //                                         ->visible(fn ($get) => in_array($get('type'), [
    //                                             BillType::PURCHASE->value, 
    //                                             BillType::RETURN->value
    //                                         ])),

    //                                     Forms\Components\TextInput::make('party_name')
    //                                         ->label('اسم الطرف')
    //                                         ->placeholder('أدخل اسم الطرف يدوياً')
    //                                         ->maxLength(255)
    //                                         ->nullable(),
    //                                 ]),

    //                             Forms\Components\Grid::make(2)
    //                                 ->schema([
    //                                     Forms\Components\Select::make('source_warehouse_id')
    //                                         ->label('المستودع المصدر')
    //                                         ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                         ->searchable()
    //                                         ->preload()
    //                                         ->nullable()
    //                                         ->visible(fn ($get) => in_array($get('type'), [
    //                                             BillType::TRANSFER->value,
    //                                             BillType::ADJUSTMENT->value,
    //                                             BillType::RETURN->value,
    //                                         ])),

    //                                     Forms\Components\Select::make('destination_warehouse_id')
    //                                         ->label('المستودع الوجهة')
    //                                         ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                         ->searchable()
    //                                         ->preload()
    //                                         ->nullable()
    //                                         ->visible(fn ($get) => in_array($get('type'), [
    //                                             BillType::PURCHASE->value,
    //                                             BillType::TRANSFER->value,
    //                                             BillType::ADJUSTMENT->value,
    //                                             BillType::RETURN->value,
    //                                         ])),
    //                                 ]),

    //                             Forms\Components\Grid::make(2)
    //                                 ->schema([
    //                                     Forms\Components\TextInput::make('reference_number')
    //                                         ->label('رقم المرجع')
    //                                         ->placeholder('رقم الفاتورة المرجعية')
    //                                         ->maxLength(255)
    //                                         ->nullable(),

    //                                     Forms\Components\DatePicker::make('reference_date')
    //                                         ->label('تاريخ المرجع')
    //                                         ->displayFormat('d/m/Y')
    //                                         ->nullable(),
    //                                 ]),

    //                             Forms\Components\Textarea::make('notes')
    //                                 ->label('ملاحظات')
    //                                 ->placeholder('أي ملاحظات إضافية حول الفاتورة...')
    //                                 ->rows(2)
    //                                 ->columnSpanFull(),
    //                         ]),

    //                      Forms\Components\Tabs\Tab::make('المواد')
    //                         ->icon('heroicon-o-shopping-cart')
    //                         ->schema([
    //                             Forms\Components\Repeater::make('bill_items')
    //                                 ->label('المواد المطلوبة')
    //                                 ->relationship('billRecords')  
    //                                 ->schema([
    //                                     Forms\Components\Grid::make(6)
    //                                         ->schema([
    //                                             Forms\Components\Select::make('item_id')
    //                                                 ->label('الصنف')
    //                                                 ->options(fn () => Item::active()->pluck('name', 'id'))
    //                                                 ->searchable()
    //                                                 ->preload()
    //                                                 ->required()
    //                                                 ->reactive()
    //                                                 ->afterStateUpdated(function ($state, callable $set) {
    //                                                     if ($item = Item::find($state)) {
    //                                                         $set('unit_price', $item->sale_price);
    //                                                     }
    //                                                 })
    //                                                 ->columnSpan(2),

    //                                             Forms\Components\TextInput::make('quantity')
    //                                                 ->label('الكمية')
    //                                                 ->numeric()
    //                                                 ->required()
    //                                                 ->minValue(0.01)
    //                                                 ->step(0.01)
    //                                                 ->reactive()
    //                                                 ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                     $unitPrice = $get('unit_price') ?? 0;
    //                                                     $set('total_price', $unitPrice * $state);
    //                                                 }),

    //                                             Forms\Components\TextInput::make('unit_price')
    //                                                 ->label('سعر الوحدة')
    //                                                 ->numeric()
    //                                                 ->required()
    //                                                 ->minValue(0)
    //                                                 ->step(0.01)
    //                                                 ->reactive()
    //                                                 ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                                     $quantity = $get('quantity') ?? 0;
    //                                                     $set('total_price', $state * $quantity);
    //                                                 }),

    //                                             Forms\Components\TextInput::make('total_price')
    //                                                 ->label('القيمة')
    //                                                 ->numeric()
    //                                                 ->disabled(),

    //                                             Forms\Components\TextInput::make('batch_number')
    //                                                 ->label('رقم الدفعة')
    //                                                 ->nullable(),

    //                                             Forms\Components\Select::make('warehouse_id')
    //                                                 ->label('المستودع')
    //                                                 ->options(fn () => Warehouse::active()->pluck('name', 'id'))
    //                                                 ->searchable()
    //                                                 ->preload()
    //                                                 ->nullable()
    //                                                 ->visible(fn ($get, $record) => 
    //                                                     $record && $record->type === BillType::TRANSFER->value
    //                                                 ),
    //                                         ]),
    //                                 ])
    //                                 ->defaultItems(1)
    //                                 ->createItemButtonLabel('➕ إضافة صنف آخر')
    //                                 ->reorderable(true)
    //                                 ->collapsible()
    //                                 ->cloneable()
    //                                 ->itemLabel(fn (array $state): ?string => 
    //                                     isset($state['item_id']) ? Item::find($state['item_id'])?->name : 'صنف جديد'
    //                                 )
    //                                 ->columnSpanFull()
    //                                 ->afterStateUpdated(function ($state, $set, $get) {
    //                                      $subtotal = 0;
    //                                     foreach ($state as $item) {
    //                                         if (isset($item['quantity']) && isset($item['unit_price'])) {
    //                                             $subtotal += ($item['quantity'] * $item['unit_price']);
    //                                         }
    //                                     }

    //                                     $set('../../subtotal', $subtotal);
    //                                     $set('../../total', $subtotal - ($get('../../discount') ?? 0) + ($get('../../tax') ?? 0));
    //                                 }),
    //                         ]),

    //                      Forms\Components\Tabs\Tab::make('الحسابات')
    //                         ->icon('heroicon-o-calculator')
    //                         ->schema([
    //                             Forms\Components\Grid::make(3)
    //                                 ->schema([
    //                                     Forms\Components\TextInput::make('subtotal')
    //                                         ->label('المجموع الفرعي')
    //                                         ->numeric()
    //                                         ->default(0)
    //                                         ->disabled()
    //                                         ->dehydrated(),

    //                                     Forms\Components\TextInput::make('discount')
    //                                         ->label('الخصم')
    //                                         ->numeric()
    //                                         ->default(0)
    //                                         ->minValue(0)
    //                                         ->reactive()
    //                                         ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                             $subtotal = $get('subtotal') ?? 0;
    //                                             $tax = $get('tax') ?? 0;
    //                                             $total = $subtotal - $state + $tax;
    //                                             $set('total', $total);
    //                                         }),

    //                                     Forms\Components\TextInput::make('tax')
    //                                         ->label('الضريبة')
    //                                         ->numeric()
    //                                         ->default(0)
    //                                         ->minValue(0)
    //                                         ->reactive()
    //                                         ->afterStateUpdated(function ($state, callable $set, $get) {
    //                                             $subtotal = $get('subtotal') ?? 0;
    //                                             $discount = $get('discount') ?? 0;
    //                                             $total = $subtotal - $discount + $state;
    //                                             $set('total', $total);
    //                                         }),
    //                                 ]),

    //                             Forms\Components\TextInput::make('total')
    //                                 ->label('الإجمالي النهائي')
    //                                 ->numeric()
    //                                 ->default(0)
    //                                 ->disabled()
    //                                 ->dehydrated()
    //                                 ->columnSpanFull(),

    //                             Forms\Components\Placeholder::make('summary')
    //                                 ->label('ملخص الفاتورة')
    //                                 ->content(function ($get) {
    //                                     $itemsCount = count($get('bill_items') ?? []);
    //                                     $subtotal = $get('subtotal') ?? 0;
    //                                     $discount = $get('discount') ?? 0;
    //                                     $tax = $get('tax') ?? 0;
    //                                     $total = $get('total') ?? 0;

    //                                     return "عدد الأصناف: {$itemsCount} | المجموع الفرعي: {$subtotal} | الخصم: {$discount} | الضريبة: {$tax} | الإجمالي: {$total}";
    //                                 })
    //                                 ->columnSpanFull(),
    //                         ]),
    //                 ])
    //                 ->columnSpanFull(),

    //             Forms\Components\Hidden::make('created_by')
    //                 ->default(filament()->auth()->id()),
    //         ]);
    // }


    // public static function table(Table $table): Table
    // {
    //     return $table
    //         ->columns([
    //             Tables\Columns\TextColumn::make('bill_number')
    //                 ->label('رقم الفاتورة')
    //                 ->searchable()
    //                 ->sortable(),

    //             Tables\Columns\TextColumn::make('date')
    //                 ->label('التاريخ')
    //                 ->date('d/m/Y')
    //                 ->sortable(),

    //             Tables\Columns\BadgeColumn::make('type')
    //                 ->label('النوع')
    //                 ->formatStateUsing(fn ($state) => BillType::from($state)->label())
    //                 ->color(fn ($state) => match($state) {
    //                     BillType::PURCHASE->value => 'success',
    //                     BillType::TRANSFER->value => 'info',
    //                     BillType::ADJUSTMENT->value => 'warning',
    //                     BillType::RETURN->value => 'primary',
    //                     default => 'gray',
    //                 }),

    //             Tables\Columns\TextColumn::make('party_name')
    //                 ->label('الطرف')
    //                 ->searchable()
    //                 ->limit(25),

    //             Tables\Columns\TextColumn::make('total')
    //                 ->label('الإجمالي')
    //                 ->money('SDG')
    //                 ->sortable(),

    //             Tables\Columns\BadgeColumn::make('status')
    //                 ->label('الحالة')
    //                 ->formatStateUsing(fn ($state) => match($state) {
    //                     BillStatus::DRAFT->value => 'مسودة',
    //                     'pending' => 'معلقة',
    //                     BillStatus::COMPLETED->value => 'مكتملة',
    //                     'cancelled' => 'ملغاة',
    //                     default => $state,
    //                 })
    //                 ->color(fn ($state) => match($state) {
    //                     BillStatus::DRAFT->value => 'gray',
    //                     'pending' => 'warning',
    //                     BillStatus::COMPLETED->value => 'success',
    //                     'cancelled' => 'danger',
    //                     default => 'gray',
    //                 }),

    //             Tables\Columns\TextColumn::make('billRecords_count')
    //                 ->label('عدد الأصناف')
    //                 ->counts('billRecords')
    //                 ->sortable(),
    //         ])
    //         ->filters([
    //             Tables\Filters\SelectFilter::make('type')
    //                 ->label('نوع الفاتورة')
    //                 ->options([
    //                     BillType::PURCHASE->value => BillType::PURCHASE->label(),
    //                     BillType::TRANSFER->value => BillType::TRANSFER->label(),
    //                     BillType::ADJUSTMENT->value => BillType::ADJUSTMENT->label(),
    //                     BillType::RETURN->value => BillType::RETURN->label(),
    //                 ])
    //                 ->placeholder('جميع الأنواع'),

    //             Tables\Filters\SelectFilter::make('status')
    //                 ->label('حالة الفاتورة')
    //                 ->options([
    //                     BillStatus::DRAFT->value => 'مسودة',
    //                     'pending' => 'معلقة',
    //                     BillStatus::COMPLETED->value => 'مكتملة',
    //                     'cancelled' => 'ملغاة',
    //                 ])
    //                 ->placeholder('جميع الحالات'),
    //         ])
    //         ->actions([
    //             Tables\Actions\ActionGroup::make([
    //                 Tables\Actions\ViewAction::make(),
    //                 Tables\Actions\EditAction::make(),

    //                 Tables\Actions\Action::make('approve')
    //                     ->label('اعتماد')
    //                     ->icon('heroicon-o-check-circle')
    //                     ->color('success')
    //                     ->visible(fn($record) => $record->status === BillStatus::DRAFT->value)
    //                     ->action(function ($record) {
    //                         $record->update([
    //                             'status' => BillStatus::COMPLETED->value,
    //                             'approved_by' => filament()->auth()->id(),
    //                             'approved_at' => now(),
    //                         ]);

    //                         Notification::make()
    //                             ->title('تم اعتماد الفاتورة بنجاح')
    //                             ->success()
    //                             ->send();
    //                     })
    //                     ->requiresConfirmation(),

    //                 Tables\Actions\DeleteAction::make(),
    //             ]),
    //         ])
    //         ->bulkActions([
    //             Tables\Actions\BulkActionGroup::make([
    //                 Tables\Actions\DeleteBulkAction::make(),
    //             ]),
    //         ])
    //         ->defaultSort('date', 'desc')
    //         ->groups([
    //             Tables\Grouping\Group::make('type')
    //                 ->label('حسب النوع')
    //                 ->collapsible(),

    //             Tables\Grouping\Group::make('status')
    //                 ->label('حسب الحالة')
    //                 ->collapsible(),
    //         ]);
    // }

    // public static function getPages(): array
    // {
    //     return [
    //         'index' => Pages\ListBills::route('/'),
    //         'create' => Pages\CreateBill::route('/create'),
    //         'edit' => Pages\EditBill::route('/{record}/edit'),
    //         'view' => Pages\ViewBill::route('/{record}'),
    //     ];
    // }
}
