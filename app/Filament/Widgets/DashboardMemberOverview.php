<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
use App\Models\Expense;
use App\Models\Payment;
use Carbon\Carbon;

class DashboardMemberOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $todayMembers = Member::whereDate('created_at', Carbon::today())
        ->where('is_guest', false)
        ->get();
        $todayMembersCount = count($todayMembers);

        $todayGuest = Member::whereDate('created_at', Carbon::today())
            ->where('is_guest', true)
            ->get();
        $todayGuestCount = count($todayGuest);


        $thisMonthExpenses = Expense::whereMonth('created_at', Carbon::now()->month)->get();
        $thisMonthExpensesTotal = $thisMonthExpenses->sum('amount');

        $thisMonthGrossSales = Payment::whereMonth('created_at', Carbon::now()->month)->get();
        $thisMonthGrossSalesTotal = $thisMonthGrossSales->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        return [
            Stat::make('New Members', $todayMembersCount)->chart([1,2,3]),
            Stat::make('Active Members', '??')->chart([1,2,3]),
            Stat::make('Guest', $todayGuestCount)->chart([1,2,3]),

            Stat::make('Total Net Profit', 'PHP '.number_format($thisMonthNetProfit, 2, '.', ','))->chart([1,2,3]),
            Stat::make('Total Gross Sales', 'PHP '.number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1,2,3]),
            Stat::make('Total Expenses', 'PHP '.number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1,2,3]),
        ];
    }
}