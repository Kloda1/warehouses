<x-filament-panels::page>
    <x-filament-panels::form wire:submit="saveItems">
        {{ $this->form }}
        
        <div class="flex justify-end gap-4 pt-6">
            {{ $this->saveAction }}
            {{ $this->cancelAction }}
        </div>
    </x-filament-panels::form>

    @script
    <script>
        
        document.addEventListener('livewire:init', () => {
            Livewire.on('calculate-total', (itemIndex) => {
                const quantity = document.querySelector(`[name="items.${itemIndex}.quantity"]`).value;
                const unitPrice = document.querySelector(`[name="items.${itemIndex}.unit_price"]`).value;
                const total = quantity * unitPrice;
                document.querySelector(`[name="items.${itemIndex}.total_price"]`).value = total.toFixed(2);
            });
        });
    </script>
    @endscript
</x-filament-panels::page>