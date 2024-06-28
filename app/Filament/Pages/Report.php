<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Form;
use App\Models\Branch;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

use App\Models\MembershipPlan;
use App\Models\Payment;

class Report extends Page
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.report';
    protected static ?int $navigationSort = 3;

    public $activeTab = "membership";

    public $tabList = [
        'membership' => 'Gym Membership',
        'access' => 'Gym Access',
        'coaching' => 'Coaching',
        'summary' => 'Summary',
    ];

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('branch_location')
                            ->label("Select Branch Location")
                            ->options(Branch::all()->pluck('name', 'name')),
                        DatePicker::make('start_date')
                            ->label('Select Start Date'),
                        DatePicker::make('end_date')
                            ->label('Select End Date'),
                    ])
                    ->columns(3),
            ]);
    }

    public function activateButton($btnName)
    {
        $this->activeTab = $btnName;
    }

    public function getMembershipPlan() {
        $respose = [];

        $memberships = MembershipPlan::all();        
        foreach ($memberships as $membership) {
            $respose[] = [
                'membership_name' => $membership->type,
                'price' => $membership->price,
                'client_count' => Payment::where('gym_membership_type', $membership->type)->count(),
                'discount' => Payment::where('gym_membership_type', $membership->type)->sum('gym_membership_discount'),
                'amount' => Payment::where('gym_membership_type', $membership->type)->sum('amount')
            ];
        }

        return $respose;
    }
}
