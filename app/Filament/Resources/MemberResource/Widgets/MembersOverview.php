<?php

namespace App\Filament\Resources\MemberResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MembersOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('New Members', 2)->chart([1,2,3]),
            Stat::make('Active Members', 10)->chart([1,2,3]),
            Stat::make('Guest', 3)->chart([1,2,3]),
        ];
    }
}
