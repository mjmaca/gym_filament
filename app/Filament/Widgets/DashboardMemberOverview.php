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
        //I get the path request then use to hide the othe stat below 
        $firstRequest = request()->all();
        // Check if 'components' key exists in $firstRequest
        if (isset($firstRequest['components'])) {
            $snapshotPath = $firstRequest['components'][0]['snapshot'];

            // Check if $snapshotPath is a string and decode it if necessary
            if (is_string($snapshotPath)) {
                $snapshotPath = json_decode($snapshotPath, true);
            }

            // Now access the nested property if $snapshotPath is an array
            if (is_array($snapshotPath) && isset($snapshotPath['memo']['path'])) {
                $path = $snapshotPath['memo']['path'];
                // Proceed with further logic using $path
            } else {
                // Handle cases where $snapshotPath or its nested properties are not as expected
                $path = null; // or throw an error, log, etc.
            }
        } else {
            // Handle case where 'components' key is not present in $firstRequest
            $path = null; // or handle accordingly
        }

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

        $MembersCount = $queryMember
            ->where('is_guest', false)
            ->count();

        $GuestCount = $queryMember
            ->where('is_guest', true)
            ->count();

        $thisMonthExpensesTotal = Expense::whereMonth('created_at', Carbon::now()->month)
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthGrossSalesTotal = Payment::whereMonth('created_at', Carbon::now()->month)
            ->where('branch_location', $branchLocation)
            ->sum('amount');

        $thisMonthNetProfit = $thisMonthGrossSalesTotal - $thisMonthExpensesTotal;

        
        $stats = [];

        if ($path === 'admin/members') {
             $stats[] = Stat::make('Active Members', '??')->chart([1, 2, 3]);
             $stats[] = Stat::make('New Members', $MembersCount)->chart([1, 2, 3]);
             $stats[] = Stat::make('Guest', $GuestCount)->chart([1, 2, 3]);
        }

        else if ($path === 'admin/expenses') {
            $stats[] = Stat::make('Total Net Profit', 'PHP ' . number_format($thisMonthNetProfit, 2, '.', ','))->chart([1, 2, 3]);
            $stats[] = Stat::make('Total Gross Sales', 'PHP ' . number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1, 2, 3]);
            $stats[] = Stat::make('Total Expenses', 'PHP ' . number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1, 2, 3]);
        }
        else {
            $stats[] = Stat::make('Active Members', '??')->chart([1, 2, 3]);
            $stats[] = Stat::make('New Members', $MembersCount)->chart([1, 2, 3]);
            $stats[] = Stat::make('Guest', $GuestCount)->chart([1, 2, 3]);

            $stats[] = Stat::make('Total Net Profit', 'PHP ' . number_format($thisMonthNetProfit, 2, '.', ','))->chart([1, 2, 3]);
            $stats[] = Stat::make('Total Gross Sales', 'PHP ' . number_format($thisMonthGrossSalesTotal, 2, '.', ','))->chart([1, 2, 3]);
            $stats[] = Stat::make('Total Expenses', 'PHP ' . number_format($thisMonthExpensesTotal, 2, '.', ','))->chart([1, 2, 3]);
        }

        return $stats;
    }
}