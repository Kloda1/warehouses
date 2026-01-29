<?php
 

namespace App\Filament\Resources\BillResource\Pages;

use App\Filament\Resources\BillResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewBill extends ViewRecord
{
    protected static string $resource = BillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\Action::make('add_items')
                ->label('➕ إضافة/تعديل مواد')
                ->icon('heroicon-o-shopping-cart')
                ->color('primary')
                ->url(fn () => BillResource::getUrl('items', ['record' => $this->record->id])), 
        ];
    }
}
// namespace App\Filament\Resources\BillResource\Pages;

// use App\Filament\Resources\BillResource;
// use Filament\Actions;
// use Filament\Resources\Pages\ViewRecord; 
// use Filament\Infolists;
// use Filament\Infolists\Infolist;
// use App\Models\BillRecord;


// class ViewBill extends ViewRecord
// {
// //     protected static string $resource = BillResource::class;

// //     protected function getHeaderActions(): array
// //     {
// //         return [
// //             Actions\EditAction::make(),
// //             Actions\DeleteAction::make(),
// //         ];
// //     }

//  protected static string $resource = BillResource::class;

//     protected function getHeaderActions(): array
//     {
//         return [
//             Actions\EditAction::make()
//                 ->label('تعديل'),
                
//             Actions\Action::make('manage_items')
//                 ->label('إدارة المواد')
//                 ->icon('heroicon-o-shopping-cart')
//                 ->url(fn () => BillResource::getUrl('items', ['record' => $this->record->id]))
//                 ->color('primary'),
//         ];
//     }

//     public function infolist(Infolist $infolist): Infolist
//     {
//         return $infolist
//             ->schema([
//                 Infolists\Components\Section::make('معلومات المذكرة')
//                     ->schema([
//                         Infolists\Components\Grid::make(4)
//                             ->schema([
//                                 Infolists\Components\TextEntry::make('bill_number')
//                                     ->label('رقم المذكرة'),
                                
//                                 Infolists\Components\TextEntry::make('date')
//                                     ->label('التاريخ')
//                                     ->date('d/m/Y'),
                                
//                                 Infolists\Components\TextEntry::make('type')
//                                     ->label('النوع')
//                                     ->badge(),
                                
//                                 Infolists\Components\TextEntry::make('status')
//                                     ->label('الحالة')
//                                     ->badge(),
//                             ]),
                        
//                         Infolists\Components\TextEntry::make('party_name')
//                             ->label('اسم الطرف')
//                             ->columnSpanFull(),
                        
//                         Infolists\Components\TextEntry::make('notes')
//                             ->label('ملاحظات')
//                             ->columnSpanFull(),
//                     ]),
                
//                 Infolists\Components\Section::make('المواد')
//                     ->schema([
//                         Infolists\Components\RepeatableEntry::make('billRecords')
//                             ->label('')
//                             ->schema([
//                                 Infolists\Components\Grid::make(6)
//                                     ->schema([
//                                         Infolists\Components\TextEntry::make('item.name')
//                                             ->label('الصنف')
//                                             ->columnSpan(2),
                                        
//                                         Infolists\Components\TextEntry::make('quantity')
//                                             ->label('الكمية'),
                                        
//                                         Infolists\Components\TextEntry::make('unit_price')
//                                             ->label('سعر الوحدة')
//                                             ->money('SDG'),
                                        
//                                         Infolists\Components\TextEntry::make('total')
//                                             ->label('الإجمالي')
//                                             ->money('SDG')
//                                             ->getStateUsing(fn ($record) => $record->quantity * $record->unit_price),
                                        
//                                         Infolists\Components\TextEntry::make('batch_number')
//                                             ->label('رقم الدفعة'),
                                        
//                                         Infolists\Components\TextEntry::make('warehouse.name')
//                                             ->label('المستودع')
//                                             ->default('غير محدد'),
//                                     ]),
//                             ])
//                             ->columns(1)
//                             ->emptyStateLabel('لا توجد مواد مضافة'),
//                     ]),
                
//                 Infolists\Components\Section::make('الحسابات')
//                     ->schema([
//                         Infolists\Components\Grid::make(3)
//                             ->schema([
//                                 Infolists\Components\TextEntry::make('subtotal')
//                                     ->label('المجموع الفرعي')
//                                     ->money('SDG'),
                                
//                                 Infolists\Components\TextEntry::make('discount')
//                                     ->label('الخصم')
//                                     ->money('SDG'),
                                
//                                 Infolists\Components\TextEntry::make('tax')
//                                     ->label('الضريبة')
//                                     ->money('SDG'),
//                             ]),
                        
//                         Infolists\Components\TextEntry::make('total')
//                             ->label('الإجمالي النهائي')
//                             ->money('SDG')
//                             ->columnSpanFull()
//                             ->size(Infolists\Components\TextEntry\TextEntrySize::Large),
//                     ]),
//             ]);
//     }
// }