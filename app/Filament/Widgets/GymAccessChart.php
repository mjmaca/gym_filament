<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Attendance;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class GymAccessChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Gym Access Statistics';

    protected function getData(): array
    {
        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();
        $shiftTime = $this->filters['shift_time'];

        // Initialize the query builder
        $queryGymAccess = Payment::query();

        if ($shiftTime === 'ALL') {
            $queryGymAccess
                ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
                ->where('branch_location', $branchLocation);
        } else {
            // Combined AM/PM condition
            $queryGymAccess
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

        $activeMembers = Attendance::select('membership_id', DB::raw('EXTRACT(MONTH FROM created_at) as month'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('branch_location', $branchLocation)
            ->havingRaw('COUNT(*) >= 3')
            ->groupBy('membership_id', 'month')
            ->get();

        $monthlyMemberCounts = array_fill(0, 12, 0); // Initialize an array with 12 zeros

        foreach ($activeMembers as $member) {
            $monthlyMemberCounts[$member->month - 1]++;
        }


        return [
            'datasets' => [
                [
                    'label' => 'Active Member',
                    'data' => $monthlyMemberCounts,
                    'backgroundColor' => '#98FF98',
                    'borderColor' => '#98FF98',
                ],
                [
                    'label' => 'Inactive Member',
                    'data' => '100',
                    'backgroundColor' => '#FFC0CB',
                    'borderColor' => '#FFC0CB',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
