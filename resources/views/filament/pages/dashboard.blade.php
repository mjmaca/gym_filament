{{-- resources/views/filament/pages/dashboard.blade.php --}}

<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>

    <div>
        <div class="mt-8">
            @livewire(\App\Filament\Widgets\MemberOverview::class, ['filters' => $this->filters])
        </div>

        <div class="mt-8">
            @livewire(\App\Filament\Widgets\SalesOverview::class, ['filters' => $this->filters])
        </div>

    </div>

    <div style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
            @livewire(\App\Filament\Widgets\MembersxChart::class, ['filters' => $this->filters])
        </div>

        <div style="flex: 1;">

            @livewire(\App\Filament\Widgets\PaymentChart::class, ['filters' => $this->filters])
        </div>
    </div>
</x-filament::page>
