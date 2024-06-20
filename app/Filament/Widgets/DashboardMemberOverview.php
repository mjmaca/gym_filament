<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use App\Models\Member;
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

        return [
            Stat::make('New Members', $todayMembersCount)->chart([1,2,3]),
            Stat::make('Active Members', '??')->chart([1,2,3]),
            Stat::make('Guest', $todayGuestCount)->chart([1,2,3]),
        ];
    }
}
