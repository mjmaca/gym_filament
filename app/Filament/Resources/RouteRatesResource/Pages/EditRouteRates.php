<?php

namespace App\Filament\Resources\RouteRatesResource\Pages;

use App\Filament\Resources\RouteRatesResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRouteRates extends EditRecord
{
    protected static string $resource = RouteRatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
