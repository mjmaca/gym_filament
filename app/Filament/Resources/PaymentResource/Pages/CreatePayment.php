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
        $this->data['full_name'] = $selectedMember->full_name;
        $this->data['branch_location'] = $selectedMember->branch_location;
        return $this->data;
    }


protected function afterCreate(): void
{
    $selectedMember = $this->data['selectedMember'];

    // TODO GEt the ID of member using the selectedmember id in form
    $selectedMember = Member::where('id', $selectedMember->id)->first();
    // $selectedMember = Member::find($selectedMember->id);

    $selectedMember->gym_access_discount = $this->record->gym_access_discount;
    $selectedMember->gym_access_expiration_date = $this->record->gym_access_expiration_date;
    $selectedMember->gym_access_start_date = $this->record->gym_access_start_date;
    $selectedMember->gym_access_plan = $this->record->gym_access_plan;
    $selectedMember->gym_access_price = $this->record->gym_access_price;
    $selectedMember->gym_access_extension = $this->record->gym_access_extension;

    $selectedMember->gym_membership_discount = $this->record->gym_membership_discount;
    $selectedMember->gym_membership_expiration_date = $this->record->gym_membership_expiration_date;
    $selectedMember->gym_membership_start_date = $this->record->gym_membership_start_date;
    $selectedMember->gym_membership_price = $this->record->gym_membership_price;
    $selectedMember->gym_membership_type = $this->record->gym_membership_type;
    $selectedMember->gym_membership_extension = $this->record->gym_membership_extension;

    $selectedMember->pt_session_coach_name = $this->record->pt_session_coach_name;
    $selectedMember->pt_session_price = $this->record->pt_session_price;
    $selectedMember->pt_session_expiration_date = $this->record->pt_session_expiration_date;
    $selectedMember->pt_session_start_date = $this->record->pt_session_start_date;
    $selectedMember->pt_session_extension = $this->record->pt_session_extension;
    $selectedMember->pt_session_type = $this->record->pt_session_type;
    $selectedMember->pt_session_total = $this->record->pt_session_total;
    $selectedMember->pt_session_used = $this->record->pt_session_used;
    $selectedMember->save();
}
}
