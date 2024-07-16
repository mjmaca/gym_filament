<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use App\Models\Member;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class GymMembershipChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Gym Membership Statistics';

    protected function getData(): array
    {
        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();
        $shiftTime = $this->filters['shift_time'];

        // Initialize the query builder
        $queryMember = Member::query();

        if ($shiftTime === 'ALL') {
            $queryMember
                ->whereDate('created_at', Carbon::today())
                ->where('branch_location', $branchLocation);
        } else {
            // Combined AM/PM condition
            $queryMember
                ->whereDate('created_at', Carbon::today())
                ->where('branch_location', $branchLocation)
                ->where(function ($query) use ($shiftTime) {
                    if ($shiftTime === 'AM') {
                        $query->whereTime('created_at', '>=', '00:00:00')
                            ->whereTime('created_at', '<', '12:00:00');
                    } else { // Assumes PM if not ALL or AM
                        $query->whereTime('created_at', '>=', '12:00:00')
                            ->whereTime('created_at', '<=', '23:59:59');
                    }
                });
        }

        $GoldMemberData = clone $queryMember;
        $SilverMemberData = clone $queryMember;

        //Get the gold membership total of all member per branch
        $GoldMemberData
            ->where('is_guest', false)
            ->where('gym_membership_type', 'Gold Membership')
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $Goldmembers = $GoldMemberData->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();

        $GoldMemberData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($Goldmembers as $Goldmember) {
            $GoldMemberData[$Goldmember->month - 1] = $Goldmember->count; // -1 because array index starts at 0
        }

        //Get the Silver membership total of all member per branch
        $SilverMemberData
            ->where('is_guest', false)
            ->where('gym_membership_type', 'Silver Membership')
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $SilverMembers = $SilverMemberData->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();
        $SilverMemberData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($SilverMembers as $SilverMember) {
            $SilverMemberData[$SilverMember->month - 1] = $SilverMember->count; // -1 because array index starts at 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Newly Joined Gold Members',
                    'data' => $GoldMemberData,
                    'backgroundColor' => '#008000',
                    'borderColor' => '#008000',
                ],
                [
                    'label' => 'Newly Joined Silver Members',
                    'data' => $SilverMemberData,
                    'backgroundColor' => '#E6E6FA',
                    'borderColor' => '#E6E6FA',
                ],
                [
                    'label' => 'Renewed Gold Membership',
                    'data' => '300',
                    'backgroundColor' => '#FFFF00',
                    'borderColor' => '#FFFF00',
                ],
                [
                    'label' => 'Renewed Silver Membership',
                    'data' => '400',
                    'backgroundColor' => '#00FFFF',
                    'borderColor' => '#00FFFF',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
