<?php

namespace App\Filament\Resources\PalletIssuanceResource\Pages;

use App\Filament\Resources\PalletIssuanceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPalletIssuances extends ListRecords
{
    protected static string $resource = PalletIssuanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
