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

    //dont remove this because the membership_id not working in create page when remove this.!!!
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return $this->data;
    }
}

