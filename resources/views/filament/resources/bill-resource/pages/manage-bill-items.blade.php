<x-filament-panels::page>
    <x-filament-panels::header :actions="$this->getHeaderActions()">
        <x-slot name="heading">
            إدارة مواد المذكرة #{{ $record->bill_number }}
        </x-slot>
        <x-slot name="description">
            تاريخ المذكرة: {{ $record->date->format('d/m/Y') }} | الإجمالي: {{ number_format($record->total, 2) }} SDG
        </x-slot>
    </x-filament-panels::header>

    <x-filament::section>
        <x-slot name="heading">
            المواد المضافة
        </x-slot>
        
        @if($this->getBillItems()->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 border">#</th>
                            <th class="px-4 py-3 border">الصنف</th>
                            <th class="px-4 py-3 border">الكمية</th>
                            <th class="px-4 py-3 border">سعر الوحدة</th>
                            <th class="px-4 py-3 border">الإجمالي</th>
                            <th class="px-4 py-3 border">رقم الدفعة</th>
                            <th class="px-4 py-3 border">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($this->getBillItems() as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 border">{{ $index + 1 }}</td>
                                <td class="px-4 py-3 border">{{ $item->item->name ?? 'غير معروف' }}</td>
                                <td class="px-4 py-3 border">{{ number_format($item->quantity, 2) }}</td>
                                <td class="px-4 py-3 border">{{ number_format($item->unit_price, 2) }} SDG</td>
                                <td class="px-4 py-3 border">{{ number_format($item->quantity * $item->unit_price, 2) }} SDG</td>
                                <td class="px-4 py-3 border">{{ $item->batch_number ?? '-' }}</td>
                                <td class="px-4 py-3 border">
                                    <x-filament::button 
                                        wire:click="deleteItem({{ $item->id }})"
                                        color="danger"
                                        size="sm"
                                        icon="heroicon-o-trash"
                                        wire:confirm="هل أنت متأكد من حذف هذا الصنف؟"
                                    >
                                        حذف
                                    </x-filament::button>
                                </td>
                            </tr>
                        @endforeach
                        <tr class="font-bold bg-gray-100">
                            <td colspan="3" class="px-4 py-3 border text-left">الإجماليات</td>
                            <td class="px-4 py-3 border"></td>
                            <td class="px-4 py-3 border">{{ number_format($this->getSubtotal(), 2) }} SDG</td>
                            <td colspan="2" class="px-4 py-3 border"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <x-heroicon-o-shopping-cart class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-semibold text-gray-900">لا توجد مواد مضافة</h3>
                <p class="mt-1 text-sm text-gray-500">ابدأ بإضافة مواد إلى المذكرة.</p>
            </div>
        @endif
    </x-filament::section>

    <x-filament::section>
        <x-slot name="heading">
            ملخص المذكرة
        </x-slot>
        
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">عدد الأصناف</p>
                <p class="text-2xl font-bold">{{ $this->getBillItems()->count() }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">المجموع الفرعي</p>
                <p class="text-2xl font-bold">{{ number_format($this->getSubtotal(), 2) }} SDG</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">الخصم</p>
                <p class="text-2xl font-bold">{{ number_format($record->discount ?? 0, 2) }} SDG</p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500">الإجمالي النهائي</p>
                <p class="text-2xl font-bold">{{ number_format($this->getTotal(), 2) }} SDG</p>
            </div>
        </div>
    </x-filament::section>
</x-filament-panels::page>