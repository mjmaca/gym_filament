<?php

namespace App\Filament\Resources\ExpenseResource\Widgets;

use App\Models\Expense;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Carbon\Carbon;

class ExpensesOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $thisMonthExpenses = Expense::whereMonth('created_at', Carbon::now()->month)->get();
        $thisMonthExpensesTotal = $thisMonthExpenses->sum('amount');

        $thisMonthGrossSales = Payment::whereMonth('created_at', Carbon::now()->month)->get();
        $thisMonthGrossSalesTotal = $thisMonthGrossSales->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        return [
            Stat::make('Total Net Profit', 'PHP '.number_format($thisMonthNetProfit, 2, '.', ','))->chart([1,2,3]),
            Stat::make('Total Gross Sales', 'PHP '.number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1,2,3]),
            Stat::make('Total Expenses', 'PHP '.number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1,2,3]),
        ];
    }
}
