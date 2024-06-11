<?php

namespace App\Filament\Resources\GymAccessPlanResource\Pages;

use App\Filament\Resources\GymAccessPlanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGymAccessPlan extends EditRecord
{
    protected static string $resource = GymAccessPlanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
