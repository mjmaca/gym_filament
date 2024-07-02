<?php

namespace App\Filament\Resources\AttendanceResource\Pages;

use App\Filament\Resources\AttendanceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAttendance extends CreateRecord
{
    protected static string $resource = AttendanceResource::class;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $selectedMember = $this->data['selectedMember'];

            //     $attendance->membership_id = $get('selectedMember.membership_id');
            //     $attendance->member_id = $get('selectedMember.id');
            //     $attendance->branch_location = $get('selectedMember.branch_location');
            //     $attendance->fullname = $get('selectedMember.fullname');
            //     $attendance->is_guest = $get('selectedMember.is_guest');

        $this->data['membership_id'] = $selectedMember->membership_id;
        $this->data['full_name'] = $selectedMember->full_name;
        $this->data['branch_location'] = $selectedMember->branch_location;
        $this->data['is_guest'] = $selectedMember->is_guest;

        return $this->data;
    }
    
}
