<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget\Card;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MembershipPlanOverview extends BaseWidget
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

        $newlyGoldMembership = clone $queryMember;
        $newlySilverMembership = clone $queryMember;

        $memberCounts = $queryMember->where('is_guest', false)->count();
        $newlyGoldMembership = $newlyGoldMembership->where('gym_membership_type', 'Gold Membership')->count();
        $newlySilverMembership = $newlySilverMembership->where('gym_membership_type', 'Silver Membership')->count();

        return [
            Stat::make('Newly Joined Gold Member', $newlyGoldMembership),
            Stat::make('Newly Joined Silver Member', $newlySilverMembership),
            Stat::make('Renewed Gold Membership', '??'),
            Stat::make('Renewed Silver Membership', '??'),
            Stat::make('Total Gym Membership', $memberCounts),
        ];
    }
}