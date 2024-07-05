<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}

        <div class="mt-4">
            <x-filament::button color="info" type="submit">
                Save
            </x-filament::button>

            
            <x-filament::button 
                color="gray"
                onclick="window.location='{{ route('filament.pages.q-r-scanner') }}'"
            >
                Cancel
            </x-filament::button>
        </div>
    </form>

</x-filament-panels::page>
