{{-- resources/views/filament/pages/report.blade.php --}}

<x-filament::page>
    <form wire:submit.prevent="submit">
        {{ $this->filtersForm }}
    </form>

  <div class="mt-6">
     @livewire(\App\Filament\Widgets\DashboardMemberOverview::class, ['filters' => $this->filters])
    </div>
</x-filament::page>
