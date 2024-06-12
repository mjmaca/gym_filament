<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;
use App\Models\Payment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMember extends CreateRecord
{
    protected static string $resource = MemberResource::class;

    protected function afterCreate() {
        $payment = new Payment();
        $payment->membership_id = $this->record->membership_id;
        $payment->gym_access_discount = $this->record->gym_access_discount;
        $payment->gym_access_expiration_date = $this->record->gym_access_expiration_date;
        $payment->gym_access_start_date = $this->record->gym_access_start_date;
        $payment->gym_access_price = $this->record->gym_access_price;
        $payment->gym_access_plan = $this->record->gym_access_plan;
        $payment->gym_access_extension = $this->record->gym_access_extension;

        $payment->gym_membership_discount = $this->record->gym_membership_discount;
        $payment->gym_membership_expiration_date = $this->record->gym_membership_expiration_date;
        $payment->gym_membership_start_date = $this->record->gym_membership_start_date;
        $payment->gym_membership_price = $this->record->gym_membership_price;
        $payment->gym_membership_type = $this->record->gym_membership_type;
        $payment->gym_membership_extension = $this->record->gym_membership_extension;

        $payment->pt_session_coach_name = $this->record->pt_session_coach_name;
        $payment->pt_session_price = $this->record->pt_session_price;
        $payment->pt_session_expiration_date = $this->record->pt_session_expiration_date;
        $payment->pt_session_start_date = $this->record->pt_session_start_date;
        $payment->pt_session_extension = $this->record->pt_session_extension;
        $payment->pt_session_type = $this->record->pt_session_type;
        $payment->pt_session_total = $this->record->pt_session_total;
        $payment->pt_session_used = $this->record->pt_session_used ?? 0;

        $payment->payment_method = $this->record->payment_method;
        $payment->amount = $this->record->amount;
        $payment->save();
    }
}

