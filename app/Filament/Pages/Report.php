<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use App\Models\Branch;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use App\Filament\Widgets\DashboardMemberOverview;
use Filament\Forms\Components\Section;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Report extends Page
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.report';

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
}
