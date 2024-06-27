<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
use App\Models\Expense;
use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class DashboardMemberOverview extends BaseWidget
{     

    use InteractsWithPageFilters;

    protected function getStats(): array  
    {
        $branchLocation = $this->filters['branch_location'] ?? null;
        $date = $this->filters['date'] ?? null;
        
        logger("branchLocation:" . $branchLocation);
        logger("date:" . $date);

        $todayMembersCount = Member::whereDate('created_at', Carbon::parse($date) ?? Carbon::today())
            ->where('is_guest', false)
            ->where('branch_location', $branchLocation)
            ->count();

        $todayGuestCount = Member::whereDate('created_at', Carbon::parse($date) ?? Carbon::today())
            ->where('is_guest', true)
            ->where('branch_location', $branchLocation)
            ->count();

        $thisMonthExpensesTotal = Expense::whereMonth('created_at', Carbon::now()->month)
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthGrossSalesTotal = Payment::whereMonth('created_at', Carbon::now()->month)
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        return [
            Stat::make('Active Members', '??')->chart([1, 2, 3]),
            Stat::make('New Members', $todayMembersCount)->chart([1, 2, 3]),
            Stat::make('Guest', $todayGuestCount)->chart([1, 2, 3]),
            Stat::make('Total Net Profit', 'PHP ' . number_format($thisMonthNetProfit, 2, '.', ','))->chart([1, 2, 3]),
            Stat::make('Total Gross Sales', 'PHP ' . number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1, 2, 3]),
            Stat::make('Total Expenses', 'PHP ' . number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1, 2, 3]),
        ];
    }
}
