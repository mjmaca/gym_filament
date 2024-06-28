{{-- resources/views/filament/pages/dashboard.blade.php --}}

<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>

    <div>
        @livewire(\App\Filament\Widgets\MemberOverview::class, ['filters' => $this->filters])
        @livewire(\App\Filament\Widgets\SalesOverview::class, ['filters' => $this->filters])
    </div>

    <div>
        @livewire(\App\Filament\Widgets\MembersxChart::class)
    </div>
</x-filament::page>
