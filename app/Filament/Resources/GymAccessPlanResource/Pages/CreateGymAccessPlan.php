<?php

namespace App\Filament\Resources\GymAccessPlanResource\Pages;

use App\Filament\Resources\GymAccessPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGymAccessPlan extends CreateRecord
{
    protected static string $resource = GymAccessPlanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
