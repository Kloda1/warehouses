{{-- <x-filament-panels::page>
    <x-filament-panels::header :actions="$this->getHeaderActions()">
        <x-slot name="heading">
            إضافة مواد للمذكرة #{{ $record->bill_number }}
        </x-slot>
    </x-filament-panels::header>

    {{ filament()->renderHook('panels::page.form.before') }}

    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        {{ filament()->renderHook('panels::page.form.actions.before') }}

        <x-filament-panels::form.actions
            :actions="$this->getFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-panels::form>
</x-filament-panels::page> --}}



<div>
    {{ $this->form }}
    
    @if (count($actions = $this->getCachedHeaderActions()))
        <div class="fi-header-actions">
            @foreach ($actions as $action)
                {{ $action }}
            @endforeach
        </div>
    @endif
</div>