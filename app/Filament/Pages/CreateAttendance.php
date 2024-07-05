<?php

namespace App\Filament\Pages;

use App\Models\Member;
use App\Models\Attendance;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class CreateAttendance extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.create-attendance';
    protected ?string $heading = 'Create Attendance';

    protected static bool $shouldRegisterNavigation = false;
    public $selectedMember;
    public $membership_id;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Search Member Name')
                    ->schema([
                        Forms\Components\Select::make('membership_id')
                            ->options(Member::all()->pluck('full_name', 'id'))
                            ->label("Membership Name")
                            ->searchable()
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $member = Member::where('id', $state)->firstOrFail();
                                $set('selectedMember', $member);
                            }),

                        Section::make('Membership Details')
                            ->columns(2)
                            ->hidden(fn($get) => !$get('selectedMember'))
                            ->schema([
                                Forms\Components\Placeholder::make('full_name')
                                    ->label('Full Name')
                                    ->content(fn($get) => $get('selectedMember.full_name')),
                                Forms\Components\Placeholder::make('email')
                                    ->label('Email')
                                    ->content(fn($get) => $get('selectedMember.email')),
                                Forms\Components\Placeholder::make('mobile_number')
                                    ->label('Mobile Number')
                                    ->content(fn($get) => $get('selectedMember.mobile_number')),
                                Forms\Components\Placeholder::make('branch_location')
                                    ->label('Branch Location')
                                    ->content(fn($get) => $get('selectedMember.branch_location'))
                            ]),
                    ]),
            ]);
    }

    public function submit()
    {
        $validatedData = $this->validate();

        $validatedData['membership_id'] = $this->selectedMember->membership_id;
        $validatedData['full_name'] = $this->selectedMember->full_name;
        $validatedData['branch_location'] = $this->selectedMember->branch_location;
        $validatedData['is_guest'] = $this->selectedMember->is_guest;

        try {
            Attendance::create($validatedData);
            // Reset the form after successful creation
            $this->reset('selectedMember', 'membership_id');
        } catch (\Exception $e) {
            logger('Error creating attendance record:', ['error' => $e->getMessage()]);
        }
    }


}
