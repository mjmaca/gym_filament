<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
use App\Models\Attendance;

use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MemberOverview extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();
        $shiftTime = $this->filters['shift_time'];

        // Initialize the query builder
        $queryMember = Member::query();

        $queryMember
            ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->where('branch_location', $branchLocation);
       
        $guestCount = clone $queryMember;

        // Count members based on is_guest attribute
        $guestCounts = $guestCount->where('is_guest', true)->count();
        
        $activeMember = Attendance::select('membership_id')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('branch_location', $branchLocation)
            ->groupBy('membership_id')
            ->havingRaw('COUNT(*) >= 3')
            ->count();

        return [
            Stat::make('Active Members', $activeMember),
            Stat::make('Inactive Members', '??'),
            Stat::make('Walkin Non-Member', $guestCounts)
        ];
    }
}