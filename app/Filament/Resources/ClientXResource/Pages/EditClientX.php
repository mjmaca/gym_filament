<?php

namespace App\Filament\Resources\ClientXResource\Pages;

use App\Filament\Resources\ClientXResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClientX extends EditRecord
{
    protected static string $resource = ClientXResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
