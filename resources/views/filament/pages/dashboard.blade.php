{{-- resources/views/filament/pages/dashboard.blade.php --}}

<x-filament::page>
    @livewire(\App\Filament\Widgets\SalesOverview::class, ['filters' => $this->filters])

    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>
    
    @livewire(\App\Filament\Widgets\MembershipPlanOverview::class, ['filters' => $this->filters])
    @livewire(\App\Filament\Widgets\MemberOverview::class, ['filters' => $this->filters])

    <div style="display: flex; gap: 1rem;">
        <div style="flex: 1;">
            @livewire(\App\Filament\Widgets\GymMembershipChart::class, ['filters' => $this->filters])
        </div>

        <div style="flex: 1;">

            @livewire(\App\Filament\Widgets\GymAccessChart::class, ['filters' => $this->filters])
        </div>
    </div>
</x-filament::page>
