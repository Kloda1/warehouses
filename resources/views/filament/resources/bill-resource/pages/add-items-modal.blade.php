<div>
     @if($showItemsModal)
        <x-filament::modal
            id="add-items-modal"
            :width="'7xl'"
            :close-button="false"
            :close-by-clicking-away="false"
        >
            <x-slot name="heading">
                إضافة مواد للفاتورة
            </x-slot>
            
            <x-slot name="description">
                فاتورة رقم: {{ $record->bill_number }} - أدخل المواد المطلوبة (3 مواد افتراضية)
            </x-slot>
            
            <div class="space-y-4">
                @foreach($itemsData as $index => $item)
                    <div class="border rounded-lg p-4 bg-gray-50">
                        <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold">المادة {{ $index + 1 }}</h3>
                            @if($index >= 3)
                                <button type="button" 
                                        wire:click="removeItemRow({{ $index }})"
                                        class="text-red-600 hover:text-red-800">
                                    <x-heroicon-o-trash class="w-5 h-5" />
                                </button>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-8 gap-4">
                             <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1">المادة</label>
                                <select wire:model="itemsData.{{ $index }}.item_id"
                                        class="w-full border-gray-300 rounded-md shadow-sm">
                                    <option value="">اختر المادة</option>
                                    @foreach(\App\Models\Item::all() as $itemOption)
                                        <option value="{{ $itemOption->id }}">
                                            {{ $itemOption->name }} ({{ $itemOption->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error("itemsData.{$index}.item_id") 
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                            
                             <div>
                                <label class="block text-sm font-medium mb-1">الكمية</label>
                                <input type="number" 
                                       wire:model="itemsData.{{ $index }}.quantity"
                                       step="0.01"
                                       min="0.01"
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            
                             <div>
                                <label class="block text-sm font-medium mb-1">السعر</label>
                                <input type="number" 
                                       wire:model="itemsData.{{ $index }}.unit_price"
                                       step="0.01"
                                       min="0"
                                       class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            
                             <div>
                                <label class="block text-sm font-medium mb-1">القيمة</label>
                                <input type="number" 
                                       value="{{ ($itemsData[$index]['quantity'] ?? 0) * ($itemsData[$index]['unit_price'] ?? 0) }}"
                                       disabled
                                       class="w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">
                            </div>
                            
                             <div class="col-span-2">
                                <label class="block text-sm font-medium mb-1">رقم الدفعة</label>
                                <input type="text" 
                                       wire:model="itemsData.{{ $index }}.batch_number"
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       placeholder="اختياري">
                            </div>
                        </div>
                    </div>
                @endforeach
                
                 <div class="text-center">
                    <button type="button" 
                            wire:click="addItemRow"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">
                        <x-heroicon-o-plus class="w-5 h-5 mr-2" />
                        إضافة مادة أخرى
                    </button>
                </div>
            </div>
            
            <x-slot name="footer">
                <div class="flex justify-end gap-4">
                    <button type="button" 
                            wire:click="closeItemsModal"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                        إلغاء
                    </button>
                    
                    <button type="button" 
                            wire:click="saveItems"
                            class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                        حفظ المواد
                    </button>
                </div>
            </x-slot>
        </x-filament::modal>
    @endif
</div>