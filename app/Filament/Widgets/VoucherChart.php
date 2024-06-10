<?php

namespace App\Filament\Widgets;

use App\Models\Voucher;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;


class VoucherChart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Daily Voucher Amount', 'PHP 5000')
                ->chart([1,2,3]),
            Stat::make('Weekly Voucher Amount', 'PHP 15000')
                ->chart([500,5000,10000]),
            Stat::make('Monthly Voucher Amount', 'PHP 150000')
                ->chart([1,2,3, 5, 10, 50])
                ->color('success')

        ];
    }
}
