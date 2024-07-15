<x-filament-panels::page>

    <form wire:submit.prevent="submit">
        {{ $this->form }}
    </form>

    @if (!is_null($members))
        @if ($this->checkIfAccessExpire() && $this->checkIfMembershipExpire())
            {{ $this->savedAttendance($members) }}
            <x-filament::card class="text-center">
                <h2 style="text-align: center">Welcome Back {{ $members->full_name }}!</h2>
                <p class="text-center">Access Granted!</p>
            </x-filament::card>
        @elseif ($this->checkIfMembershipExpire())
            <x-filament::card class="text-center">
                <h2 style="text-align: center">Hi {{ $members->full_name }}!</h2>
                <p class="text-center">Your gym membership has expired. Please contact our staff for assistance.</p>
            </x-filament::card>
        @else
            <x-filament::card class="text-center">
                <h2 style="text-align: center">Hi {{ $members->full_name }}!
                </h2>
                <p class="text-center">Your gym access has expired. Please contact our staff for assistance.</p>
                assistance.</p>
            </x-filament::card>
        @endif
    @else
        <x-filament::card class="text-center">
            <h2 style="text-align: center">Please scan your QR code.</h2>
        </x-filament::card>
    @endif

    <div style="text-align: end">
        <x-filament::button style="width: 155px;"
            onclick="window.location='{{ route('filament.pages.create-attendance') }}'">Create
            Attendance
        </x-filament::button>
        {{ $this->table }}
    </div>
</x-filament-panels::page>
