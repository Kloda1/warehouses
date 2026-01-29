@extends('filament-panels::layouts.base')

@section('content')
     {{ $this->form }}
    
  
    <div class="filament-page-actions">
        @foreach ($this->getCachedFormActions() as $action)
            {{ $action }}
        @endforeach
    </div>
 
    @if($this->showItemsModal)
        <div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto">
            {{-- Overlay --}}
            <div class="fixed inset-0 bg-black bg-opacity-50"></div>
            
            {{-- Modal --}}
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg shadow-xl w-full max-w-7xl">
                    {{-- Header --}}
                    <div class="px-6 py-4 border-b">
                        <div class="flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">
                                إضافة مواد للفاتورة
                            </h3>
                            <button @click="$wire.closeItemsModal()" 
                                    class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="mt-1 text-sm text-gray-600">
                            فاتورة رقم: {{ $this->record->bill_number ?? '' }} - أدخل المواد المطلوبة (3 مواد افتراضية)
                        </p>
                    </div>
                    
                     <div class="px-6 py-4 max-h-[60vh] overflow-y-auto">
                        @foreach($this->itemsData as $index => $item)
                            <div class="border rounded-lg p-4 mb-4 bg-gray-50">
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-bold text-gray-700">المادة {{ $index + 1 }}</h4>
                                    @if($index >= 3)
                                        <button type="button" 
                                                wire:click="removeItemRow({{ $index }})"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                            حذف
                                        </button>
                                    @endif
                                </div>
                                
                                <div class="grid grid-cols-8 gap-3">
                                     <div class="col-span-2">
                                        <label class="block text-sm font-medium mb-1 text-gray-700">المادة *</label>
                                        <select wire:model="itemsData.{{ $index }}.item_id"
                                                wire:change="calculateTotalPrice({{ $index }})"
                                                class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <option value="">اختر المادة</option>
                                            @foreach($this->getItemsList() as $id => $name)
                                                <option value="{{ $id }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                        @error("itemsData.{$index}.item_id") 
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                     <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700">الكمية *</label>
                                        <input type="number" 
                                               wire:model="itemsData.{{ $index }}.quantity"
                                               wire:change="calculateTotalPrice({{ $index }})"
                                               step="0.01"
                                               min="0.01"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error("itemsData.{$index}.quantity") 
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                             
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700">السعر *</label>
                                        <input type="number" 
                                               wire:model="itemsData.{{ $index }}.unit_price"
                                               wire:change="calculateTotalPrice({{ $index }})"
                                               step="0.01"
                                               min="0"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        @error("itemsData.{$index}.unit_price") 
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                
                                    <div>
                                        <label class="block text-sm font-medium mb-1 text-gray-700">القيمة</label>
                                        <input type="text" 
                                               value="{{ number_format(($this->itemsData[$index]['quantity'] ?? 0) * ($this->itemsData[$index]['unit_price'] ?? 0), 2) }}"
                                               disabled
                                               class="w-full border-gray-300 bg-gray-100 rounded-md shadow-sm">
                                    </div>
                                    
                                 
                                    <div class="col-span-2">
                                        <label class="block text-sm font-medium mb-1 text-gray-700">رقم الدفعة</label>
                                        <input type="text" 
                                               wire:model="itemsData.{{ $index }}.batch_number"
                                               class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                               placeholder="اختياري">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                         <div class="text-center mt-4">
                            <button type="button" 
                                    wire:click="addItemRow"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                                إضافة مادة أخرى
                            </button>
                        </div>
                    </div>
                    
                    {{-- Footer --}}
                    <div class="px-6 py-4 border-t bg-gray-50">
                        <div class="flex justify-end gap-3">
                            <button type="button" 
                                    wire:click="closeItemsModal"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                إلغاء
                            </button>
                            
                            <button type="button" 
                                    wire:click="saveItems"
                                    class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                حفظ المواد
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @script
    <script>
         document.addEventListener('livewire:init', () => {
            Livewire.on('modal-opened', () => {
                 setTimeout(() => {
                    document.querySelectorAll('select[wire\\:model^="itemsData"]').forEach(select => {
                        select.addEventListener('change', function(e) {
                            const index = this.getAttribute('wire:model').match(/itemsData\.(\d+)\.item_id/)[1];
                            Livewire.dispatch('calculate-total', { index: index });
                        });
                    });
                }, 100);
            });
        });
    </script>
    @endscript
@endsection