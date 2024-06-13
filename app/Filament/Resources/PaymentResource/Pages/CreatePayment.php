<?php

namespace App\Filament\Resources\PaymentResource\Pages;

use App\Filament\Resources\PaymentResource;
use Filament\Actions;
use App\Models\Payment;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Member;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $selectedMember = $this->data['selectedMember'];
        $this->data['membership_id'] = $selectedMember->membership_id;
        $this->data['branch_location'] = $selectedMember->branch_location;
        return $this->data;
    }
}
