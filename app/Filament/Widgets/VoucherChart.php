<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class VoucherChart extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Active Member', '10')
                ->chart([1,2,3]),
            Stat::make('New Member', '4')
                ->chart([500,5000,10000]),
            Stat::make('Guest', '15')
                ->chart([1,2,3, 5, 10, 50])
                ->color('success')
        ];
    }
}
