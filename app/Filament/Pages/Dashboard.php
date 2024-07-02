<?php
namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use App\Models\Branch;
use Carbon\Carbon;

use Filament\Pages\Dashboard as BasePage;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;

class Dashboard extends BasePage
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static string $view = 'filament.pages.dashboard';

    public $branchLocation;

    public $startDate;

    public $endDate;

    public function mount()
    {
        $this->branchLocation = Branch::first()->name;
        $this->startDate = Carbon::now();
        $this->endDate = Carbon::today();
    }

    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                      Select::make('branch_location')
                            ->label("Select Branch Location")
                            ->options(Branch::all()->pluck('name', 'name'))
                            ->default(Branch::first()->name)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->branchLocation = $state;
                            }),
                        DatePicker::make('start_date')
                            ->label('Select Start Date')
                            ->default(Carbon::now())
                            ->afterStateUpdated(function (callable $set, $get) {
                                $set('startDate', $get('start_date'));
                            }),
                        DatePicker::make('end_date')
                            ->label('Select End Date')
                            ->default(Carbon::now())
                            ->afterStateUpdated(function (callable $set, $get) {
                                $set('endDate', $get('end_date'));
                            }),
                    ])
                    ->columns(3),
            ]);
    }
}