<?php

namespace App\Filament\Widgets;
use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class PaymentChart extends ChartWidget
{
    use InteractsWithPageFilters;
    protected static ?string $heading = 'Payments Chart';

    protected function getData(): array
    {
        $branchLocation = $this->filters['branch_location'];
        $startDate = $this->filters['start_date'] ?? Carbon::today();
        $endDate = $this->filters['end_date'] ?? Carbon::today();
        $shiftTime = $this->filters['shift_time'];

        // Initialize the query builder
        $queryPayment = Payment::query();

        if ($shiftTime === 'ALL') {
            $queryPayment
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
        }

        $cloneTransactionAmount = clone $queryPayment;
        $cloneTransactionSubscription = clone $queryPayment;

        //Get the total amount per branch and group into month
        $cloneTransactionAmount
        ->selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM(amount) as total_amount')
        ->groupByRaw('EXTRACT(MONTH FROM created_at)');

        $payments = $cloneTransactionAmount->get();
        $paymentsData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($payments as $payment) {
            $paymentsData[$payment->month - 1] = $payment->total_amount; // -1 because array index starts at 0
        }

        //Get the total subscriber per branch and group into month
        $cloneTransactionSubscription
        ->selectRaw('EXTRACT(MONTH FROM created_at) as month, count(*) as count');

        $subscriptions = $cloneTransactionSubscription->groupByRaw('EXTRACT(MONTH FROM created_at)')->get();
        $subscriptionsData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($subscriptions as $subscription) {
            $subscriptionsData[$subscription->month - 1] = $subscription->count; // -1 because array index starts at 0
        }

        return [
            'datasets' => [
                [
                    'label' => 'Transaction Amount',
                    'data' => $paymentsData,
                ],
                [
                    'label' => 'Transaction Subscriber',
                    'data' => $subscriptionsData,
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
