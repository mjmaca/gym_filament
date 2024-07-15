<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use App\Filament\Widgets\SalesOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Models\Branch;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class ListExpenses extends ListRecords
{
    use HasFiltersForm;

    protected static string $resource = ExpenseResource::class;

    protected static string $view = 'filament.resources.expenses.pages.list-expenses';

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
                        Select::make('shift_time')
                            ->label("Select Shift Schedule")
                            ->options([
                                'AM' => 'AM Shift',
                                'PM' => 'PM Shift',
                                'ALL' => 'All Shift',
                            ])
                            ->default('ALL')
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->shiftTime = $state;
                            }),
                    ])
                    ->columns(4),
            ]);
    }

    protected function getWidgets(): array
    {
        return [
            SalesOverview::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Create Expense"),
        ];
    }
}
