<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Filament\Widgets\MemberOverview;
use Filament\Forms\Form;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use App\Models\Branch;
use Filament\Forms\Components\Section;

use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class ListMembers extends ListRecords
{    
    use HasFiltersForm;

    protected static string $resource = MemberResource::class;
    protected static string $view = 'filament.resources.members.pages.list-members';

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

    protected function getWidgets(): array
    {
        return [
            MemberOverview::class
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label("Create Member"),
        ];
    }

   
}
