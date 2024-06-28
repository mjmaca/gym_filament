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
        $branchLocation = $this->filters['branch_location'] ?? null;
        $startDate = Carbon::now()->startOfYear();
        $endDate = Carbon::now()->endOfYear();

        // Initialize the query builder
        $queryPayment = Payment::query();

        $cloneTransactionAmount = clone $queryPayment;
        $cloneTransactionSubscription = clone $queryPayment;

        //Get the total amount per branch and group into month
        $cloneTransactionAmount
        ->where('branch_location', $branchLocation)
        ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
        ->selectRaw('EXTRACT(MONTH FROM created_at) as month, SUM(amount) as total_amount')
        ->groupByRaw('EXTRACT(MONTH FROM created_at)');


        $payments = $cloneTransactionAmount->get();
        $paymentsData = array_fill(0, 12, 0); // Initialize an array with 12 zeros for each month

        foreach ($payments as $payment) {
            $paymentsData[$payment->month - 1] = $payment->total_amount; // -1 because array index starts at 0
        }

        //Get the total subscriber per branch and group into month
        $cloneTransactionSubscription
        ->where('branch_location', $branchLocation)
        ->whereBetween('created_at', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
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
