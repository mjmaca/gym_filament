<?php

namespace App\Filament\Resources\GroupClassResource\Pages;

use App\Filament\Resources\GroupClassResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGroupClass extends CreateRecord
{
    protected static string $resource = GroupClassResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
