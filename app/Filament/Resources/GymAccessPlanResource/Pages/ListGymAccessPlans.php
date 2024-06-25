<?php

namespace App\Filament\Resources\GymAccessPlanResource\Pages;

use App\Filament\Resources\GymAccessPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGymAccessPlans extends ListRecords
{
    protected static string $resource = GymAccessPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label("Create Gym Access Plan"),
        ];
    }
}
