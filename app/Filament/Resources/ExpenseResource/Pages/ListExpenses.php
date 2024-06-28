<?php

namespace App\Filament\Resources\ExpenseResource\Pages;

use App\Filament\Resources\ExpenseResource;
use App\Filament\Widgets\DashboardMemberOverview;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListExpenses extends ListRecords
{
    protected static string $resource = ExpenseResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            DashboardMemberOverview::class
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
