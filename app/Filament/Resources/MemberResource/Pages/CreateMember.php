<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Filament\Resources\PaymentResource;

use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;
    protected static bool $canCreateAnother = false;

    protected function getRedirectUrl(): string
    {
        return PaymentResource::getUrl('create');
    }
}

