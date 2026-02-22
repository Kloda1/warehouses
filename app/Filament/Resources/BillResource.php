<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BillResource\Pages;
use App\Models\Bill;
 
use App\Enums\BillType;
use App\Enums\BillStatus;
 
use Filament\Navigation\NavigationItem;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
 
class BillResource extends Resource
{

    protected static ?string $model = Bill::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'المذكرات';
    protected static ?string $modelLabel = 'مذكرة';
    protected static ?string $pluralModelLabel = 'المذكرات';
    protected static ?string $activeNavigationIcon = 'heroicon-o-chevron-double-down';

    protected static ?int $navigationSort = 2;
 
    public static function form(Form $form): Form
    {
        return $form;
        
    }

    public static function table(Table $table): Table
    {
        return $table
           ->modifyQueryUsing(fn ($query) => $query->when(request('type'), fn ($q, $type) => $q->where('type', $type)))
           
            ->columns([
                Tables\Columns\TextColumn::make('bill_number')
                    ->label('رقم المذكرة')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('date')
                    ->label('التاريخ')
                    ->date('d/m/Y')
                    ->sortable(),

 

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

    // public static function getNavigationBadge(): ?string
    // {
    //     return static::getModel()::count();
    // }

    public static function getNavigationItems(): array
{
    return [
        NavigationItem::make('كل المذكرات')
            ->icon('heroicon-o-document-text')
            ->url(static::getUrl('index'))
            ->group('المذكرات')
            ->sort(1),

        NavigationItem::make('استلام') 
            ->icon('heroicon-o-shopping-cart')
            ->url(static::getUrl('index', ['type' => BillType::PURCHASE->value]))
            ->group('المذكرات')
            ->sort(2),

        NavigationItem::make('تسليم')  
            ->icon('heroicon-o-arrow-path')
            ->url(static::getUrl('index', ['type' => BillType::TRANSFER->value]))
            ->group('المذكرات')
            ->sort(3),

        NavigationItem::make('تركيب وتنسيق')  
            ->icon('heroicon-o-pencil-square')
            ->url(static::getUrl('index', ['type' => BillType::ADJUSTMENT->value]))
            ->group('المذكرات')
            ->sort(4),

        NavigationItem::make('إدخال')  
            ->icon('heroicon-o-arrow-uturn-left')
            ->url(static::getUrl('index', ['type' => BillType::RETURN->value]))
            ->group('المذكرات')
            ->sort(5),
    ];
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

    

     
}
