<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Expense;
use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class SalesOverview extends BaseWidget
{

    use InteractsWithPageFilters;

    protected function getStats(): array
    {

        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();

        // Apply date range filter if both dates are provided
        $thisMonthExpensesTotal = Expense::whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthGrossSalesTotal = Payment::whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        return [
            Stat::make('Total Net Profit', 'PHP ' . number_format($thisMonthNetProfit, 2, '.', ','))->chart([1, 2, 3]),
            Stat::make('Total Gross Sales', 'PHP ' . number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1, 2, 3]),
            Stat::make('Total Expenses', 'PHP ' . number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1, 2, 3]),
        ];
    }
}