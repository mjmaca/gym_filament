<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class MemberOverview extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {
        $branchLocation = $this->filters['branch_location'] ?? null;
        $startDate = $this->filters['start_date'] ?? null;
        $endDate = $this->filters['end_date'] ?? null;

        // Initialize the query builder
        $queryMember = Member::query();

        // Apply date range filter if both dates are provided
        if ($startDate && $endDate) {
            $queryMember->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        } elseif ($startDate) {
            // Apply only start date filter if end date is not provided
            $queryMember->where('created_at', '>=', Carbon::parse($startDate)->startOfDay());

        } elseif ($endDate) {
            // Apply only end date filter if start date is not provided
            $queryMember->where('created_at', '<=', Carbon::parse($endDate)->endOfDay());
        }

        // Apply branch location filter if provided
        if ($branchLocation) {
            $queryMember->where('branch_location', $branchLocation);
        }

        $memberCount = clone $queryMember;
        $guestCount = clone $queryMember;

        // Count members based on is_guest attribute
        $guestCounts = $guestCount->where('is_guest', true)->count();
        $memberCounts = $memberCount->where('is_guest', false)->count();

        return [
            Stat::make('Active Members', '??')->chart([1, 2, 3]),
            Stat::make('New Members', $memberCounts)->chart([1, 2, 3]),
            Stat::make('Guest', $guestCounts)->chart([1, 2, 3]),
        ];
    }
}