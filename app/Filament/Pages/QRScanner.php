<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Member;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;

class QRScanner extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.q-r-scanner';

    public $membership_id;
    public $members;

    // public function mount()
    // {
    //     $this->members = [];
    // }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('membership_id')
                    ->label("Membership ID")
                    ->live(onBlur: true)
                    ->debounce(1000) // Debounce of 3 seconds
                    ->autofocus()
                    ->afterStateUpdated(function ($state) {
                        $this->filterMembers($state);
                    }), // Pass a closure here
            ]);
    }

    public function filterMembers($value)
    {
        // Add your filtering logic here
        $this->members = Member::where('membership_id', $value)->first();
    }
}
