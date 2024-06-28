<x-filament::page>

    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>

    <div class="mt-6">
        @foreach ($this->getWidgets() as $widget)
            @livewire($widget, ['filters' => $this->filters])
        @endforeach
    </div>

    <div class="mt-6">
        {{ $this->table }}
    </div>
</x-filament::page>
