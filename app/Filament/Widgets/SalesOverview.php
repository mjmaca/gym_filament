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
        $shiftTime = $this->filters['shift_time'];

        $queryPayment = Payment::query();
        $queryExpense = Expense::query();

        if ($shiftTime === 'ALL') {
            $queryPayment
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->where('branch_location', $branchLocation);
            $queryExpense
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->where('branch_location', $branchLocation);
        } else {
            // Combined AM/PM condition
            $queryPayment
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
            // Combined AM/PM condition
            $queryExpense
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

        // Apply date range filter if both dates are provided
        $thisMonthExpensesTotal = $queryExpense->sum('amount');
        $thisMonthGrossSalesTotal = $queryPayment->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        return [
            Stat::make('Total Gross Sales', 'PHP ' . number_format($thisMonthGrossSalesTotal, 2, '.', ',')),
            Stat::make('Total Expenses', 'PHP ' . number_format($thisMonthExpensesTotal, 2, '.', ',')),
            Stat::make('Total Net Profit', 'PHP ' . number_format($thisMonthNetProfit, 2, '.', ',')),
        ];
    }
}