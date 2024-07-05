<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use Filament\Pages\Page;
use App\Models\Member;

use Filament\Forms;
use Filament\Forms\Form;

class QRScanner extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static string $view = 'filament.pages.q-r-scanner';

    protected ?string $heading = 'Scan QR';

    public $membership_id;

    public $members;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('membership_id')
                    ->label("Membership ID")
                    ->live(onBlur: true)
                    ->debounce(1000) // Debounce of 3 seconds
                    ->autofocus()
                    ->autocomplete(false)
                    ->afterStateUpdated(function ($state) {
                        $this->filterMembers($state);
                        $this->resetForm();
                    }), // Pass a closure here
            ]);
    }

    public function filterMembers($value)
    {
        // Add your filtering logic here
        $this->members = Member::where('membership_id', $value)->first();
    }

    public function checkIfAccessExpire() {
        return $this->members->gym_access_expiration_date >= now()->format('Y-m-d');
    }

    public function checkIfMembershipExpire() {
        return $this->members->gym_membership_expiration_date >= now()->format('Y-m-d');
    }

    public function resetForm()
    {
        // Reset the form state
        $this->form->fill(['membership_id' => null]);
    }

    public function savedAttendance($data)
    {
        $newAttendance =  new Attendance();
        $newAttendance['membership_id'] = $data->membership_id;
        $newAttendance['full_name'] = $data->full_name;
        $newAttendance['branch_location'] = $data->branch_location;
        $newAttendance['is_guest'] = $data->is_guest;
        $newAttendance->save();
    }
}
