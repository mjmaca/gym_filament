<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use App\Models\Member;

use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MembersxChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Members Chart';

    protected function getData(): array
    {
        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();

        // Initialize the query builder
        $queryMember = Member::query();

        $cloneMemberData = clone $queryMember;
        $cloneGuestData = clone $queryMember;

        //Get the total of all member per branch
        $cloneMemberData
            ->where('branch_location', $branchLocation)
            ->where('is_guest', false)
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $members = $cloneMemberData->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();

        $memberData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($members as $member) {
            $memberData[$member->month - 1] = $member->count; // -1 because array index starts at 0
        }

        //Get the total of all guest per branch
        $cloneGuestData
            ->where('branch_location', $branchLocation)
            ->where('is_guest', true)
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $guests = $cloneGuestData->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();

        $guestData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($guests as $guest) {
            $guestData[$guest->month - 1] = $guest->count; // -1 because array index starts at 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Members',
                    'data' => $memberData,
                    'backgroundColor' => '#FFFF00',
                    'borderColor' => '#FFFF00',
                ],
                [
                    'label' => 'Guest',
                    'data' => $guestData,
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
