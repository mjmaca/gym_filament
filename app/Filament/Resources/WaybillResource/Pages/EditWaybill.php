<?php

namespace App\Filament\Resources\WaybillResource\Pages;

use App\Filament\Resources\WaybillResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWaybill extends EditRecord
{
    protected static string $resource = WaybillResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
