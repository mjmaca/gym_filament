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
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->where('branch_location', $branchLocation);
        } else {
            // Combined AM/PM condition
            $queryMember
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
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

        $cloneMemberData = clone $queryMember;

        //Get the total of all member per branch
        $cloneMemberData
            ->where('is_guest', false)
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $members = $cloneMemberData->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();

        $memberData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($members as $member) {
            $memberData[$member->month - 1] = $member->count; // -1 because array index starts at 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Newly Joined Gold Members',
                    'data' => '100',
                    'backgroundColor' => '#008000',
                    'borderColor' => '#008000',
                ],
                [
                    'label' => 'Newly Joined Silver Members',
                    'data' => '200',
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
