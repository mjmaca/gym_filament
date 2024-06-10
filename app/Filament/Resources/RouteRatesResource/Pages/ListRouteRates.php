<?php

namespace App\Filament\Resources\RouteRatesResource\Pages;

use App\Filament\Resources\RouteRatesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRouteRates extends ListRecords
{
    protected static string $resource = RouteRatesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
