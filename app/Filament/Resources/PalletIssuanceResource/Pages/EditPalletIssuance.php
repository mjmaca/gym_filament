<?php

namespace App\Filament\Resources\PalletIssuanceResource\Pages;

use App\Filament\Resources\PalletIssuanceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPalletIssuance extends EditRecord
{
    protected static string $resource = PalletIssuanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
