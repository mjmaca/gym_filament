<?php

namespace App\Filament\Resources\TrainingTypeResource\Pages;

use App\Filament\Resources\TrainingTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrainingType extends EditRecord
{
    protected static string $resource = TrainingTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
