<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    @if (!is_null($members))
        @if ( $this->checkIfAccessExpire() && $this->checkIfMembershipExpire() )
            {{ $this->savedAttendance($members) }}
            <x-filament::card class="text-center">
                <h2 style="font-size: 32px; text-align: center">Welcome Back {{ $members->full_name }}!</h2>
                <p class="text-center">Access Granted!</p>
            </x-filament::card>
        @else
            <x-filament::card class="text-center">
                <h2 style="font-size: 32px; text-align: center">Hi {{ $members->full_name }}!
                </h2>
                <p class="text-center">Your gym membership or access has expired. Please contact our staff for
                    assistance.</p>
            </x-filament::card>
        @endif
    @else
        <x-filament::card class="text-center">
            <h2 style="font-size: 32px; text-align: center">Please scan your QR code.</h2>
        </x-filament::card>
    @endif

</x-filament-panels::page>
