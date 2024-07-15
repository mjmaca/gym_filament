<?php

namespace App\Filament\Pages;

use App\Models\GymAccessPlan;
use App\Models\TrainingType;
use Filament\Pages\Page;
use Filament\Forms\Form;
use App\Models\Branch;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Carbon\Carbon;

use App\Models\MembershipPlan;
use App\Models\Payment;

class Report extends Page
{
    use HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static string $view = 'filament.pages.report';
    protected static ?int $navigationSort = 3;

    public $activeTab = "Gym Membership";
    public $branchLocation;

    public $startDate;

    public $endDate;

    public $tabList = [
        'membership' => 'Gym Membership',
        'access' => 'Gym Access',
        'coaching' => 'Coaching',
        'summary' => 'Summary',
    ];

    public $tableHeaderMembership = [
        'Plan',
        'Price',
        'No. of Clients',
        'Discounts',
        'Amount',
    ];

    public $tableHeaderCoaching = [
        'Coaching',
        '1 Session',
        '12 Session',
        '26 Session',
        '30 Session',
        '60 Session',
        '90 Session',
        'Amount',
    ];

    public $tableHeaderSummary = [
        'Type',
        'Total Amount',
        'Bank Transfer',
        'Cash',
        'Check',
        'Credit Card',
        'Debit Card',
        'Gcash',
        'Paymaya',
    ];

    public function mount()
    {
        $this->branchLocation = Branch::first()->name;
        $this->startDate = Carbon::now()->format('Y-m-d');
        $this->endDate = Carbon::today()->format('Y-m-d');
    }


    public function filtersForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('branch_location')
                            ->label("Select Branch Location")
                            ->options(Branch::all()->pluck('name', 'name'))
                            ->live()
                            ->default(Branch::first()->name)
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->branchLocation = $state;
                            }),
                        DatePicker::make('start_date')
                            ->label('Select Start Date')
                            ->default(Carbon::now())
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->startDate = $state;

                            }),
                        DatePicker::make('end_date')
                            ->label('Select End Date')
                            ->default(Carbon::now())
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->endDate = $state;
                            }),
                            Select::make('shift_time')
                            ->label("Select Shift Schedule")
                            ->options([
                                'AM' => 'AM Shift',
                                'PM' => 'PM Shift',
                                'ALL' => 'All Shift',
                            ])
                            ->default('ALL')
                            ->afterStateUpdated(function (callable $set, $state) {
                                $this->shiftTime = $state;
                            }),
                    ])
                    ->columns(4),
            ]);
    }

    public function activateButton($btnName)
    {
        $this->activeTab = $btnName;
    }

    public function getMembershipPlan()
    {
        $response = [];
        $allData = MembershipPlan::where('branch_location', $this->branchLocation)->get();

        foreach ($allData as $data) {
            $filterData = Payment::where('gym_membership_type', $data->type)
                ->where('branch_location', $this->branchLocation)
                ->whereBetween('created_at', [Carbon::parse($this->startDate)->startOfDay(), Carbon::parse($this->endDate)->endOfDay()]);

            $getDiscount = $filterData->sum('gym_membership_discount') / 100 * $data->price;
            $getTotalClient = $filterData->count();
            $getAmount = ($data->price * $getTotalClient) - $getDiscount;

            $response[] = [
                'type' => $data->type,
                'price' => number_format($data->price, 2, '.', ''),
                'client_count' => $getTotalClient,
                'discount' => number_format($getDiscount, 2, '.', ''),
                'amount' => number_format($getAmount, 2, '.', ',')
            ];
        }

        return $response;
    }

    public function getAccessPlan()
    {
        $response = [];

        $allData = GymAccessPlan::where('branch_location', $this->branchLocation)->get()
            ->sortBy('description');

        foreach ($allData as $data) {
            $filterData = Payment::where('gym_access_plan', $data->description)->where('branch_location', $this->branchLocation);
            $getDiscount = $filterData->sum('gym_access_discount') / 100 * $data->price;
            $getTotalClient = $filterData->count();
            $getAmount = ($data->price * $getTotalClient) - $getDiscount;

            $response[] = [
                'type' => $data->description,
                'price' => number_format($data->price, 2, '.', ','),
                'client_count' => $getTotalClient,
                'discount' => number_format($getDiscount, 2, '.', ''),
                'amount' => number_format($getAmount, 2, '.', ',')
            ];
        }

        return $response;
    }

    public function getCoachingPlan()
    {
        $response = [];

        $allData = TrainingType::where('branch_location', $this->branchLocation)->get();

        foreach ($allData as $data) {
            // Check if $data is already in $response
            $found = false;
            foreach ($response as $item) {
                if ($item['type'] === $data->description) {
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $response[] = [
                    'type' => $data->description,
                    '1-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 1)->count(),
                    '12-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 12)->count(),
                    '26-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 26)->count(),
                    '30-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 30)->count(),
                    '60-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 60)->count(),
                    '90-session' => Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->where('pt_session_total', 90)->count(),
                    'amount' => number_format(Payment::where('pt_session_type', $data->description)->where('branch_location', $this->branchLocation)->sum('pt_session_price'), 2, '.', ',')
                ];
            }
        }

        return $response;
    }

    public function getSummary()
    {
        $filterData = Payment::where('branch_location', $this->branchLocation)->get();
        //filter all data by paymenth method
        $getAllPaymentByCash = $filterData->where('payment_method', 'Cash');
        $getAllPaymentByBankTransfer = $filterData->where('payment_method', 'Bank Transfer');
        $getAllPaymentByCreditCard = $filterData->where('payment_method', 'Credit Card');
        $getAllPaymentByCheck = $filterData->where('payment_method', 'Check');
        $getAllPaymentByDebitCard = $filterData->where('payment_method', 'Debit Card');
        $getAllPaymentByGcash = $filterData->where('payment_method', 'Gcash');
        $getAllPaymentByPaymaya = $filterData->where('payment_method', 'Paymaya');

        $getTotalAmountCashByMembership =
            $getTotalAmountBankByMembership =
            $getTotalAmountCreditCardByMembership =
            $getTotalAmountCheckByMembership =
            $getTotalAmountDebitCardByMembership =
            $getTotalAmountGcashByMembership =
            $getTotalAmountPaymayaByMembership =

            $getTotalAmountCashByAccess =
            $getTotalAmountBankByAccess =
            $getTotalAmountCheckByAccess =
            $getTotalAmountCreditCardByAccess =
            $getTotalAmountDebitCardByAccess =
            $getTotalAmountGcashByAccess =
            $getTotalAmountPaymayaByAccess =

            $getTotalAmountCashByPT =
            $getTotalAmountBankByPT =
            $getTotalAmountCheckByPT =
            $getTotalAmountCreditCardByPT =
            $getTotalAmountDebitCardByPT =
            $getTotalAmountGcashByPT =
            $getTotalAmountPaymayaByPT = 0; // Initialize total amounts


        foreach ($getAllPaymentByCash as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountCashByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountCashByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountCashByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByBankTransfer as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountBankByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountBankByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountBankByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByCreditCard as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountCreditCardByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountCreditCardByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountCreditCardByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByDebitCard as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountDebitCardByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountDebitCardByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountDebitCardByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByGcash as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountGcashByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountGcashByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountGcashByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByPaymaya as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountPaymayaByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountPaymayaByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountPaymayaByPT += $ptAmountPerRow;
        }
        ;

        foreach ($getAllPaymentByCheck as $row) {
            $membershipAmountPerRow = $row->gym_membership_price - ($row->gym_membership_price * $row->gym_membership_discount / 100);
            $getTotalAmountCheckByMembership += $membershipAmountPerRow;

            $accessAmountPerRow = $row->gym_access_price - ($row->gym_access_price * $row->gym_access_discount / 100);
            $getTotalAmountCheckByAccess += $accessAmountPerRow;

            $ptAmountPerRow = $row->pt_session_price;
            $getTotalAmountCheckByPT += $ptAmountPerRow;
        }
        ;

        $getTotalMembership = $getTotalAmountCashByMembership + $getTotalAmountBankByMembership + $getTotalAmountCreditCardByMembership + $getTotalAmountDebitCardByMembership + $getTotalAmountGcashByMembership + $getTotalAmountPaymayaByMembership + $getTotalAmountCheckByMembership;
        $getTotalAccess = $getTotalAmountCashByAccess + $getTotalAmountBankByAccess + $getTotalAmountCreditCardByAccess + $getTotalAmountDebitCardByAccess + $getTotalAmountGcashByAccess + $getTotalAmountPaymayaByAccess + $getTotalAmountCheckByAccess;
        $getTotalPT = $getTotalAmountCashByPT + $getTotalAmountBankByPT + $getTotalAmountCreditCardByPT + $getTotalAmountDebitCardByPT + $getTotalAmountGcashByPT + $getTotalAmountPaymayaByPT + $getTotalAmountCheckByPT;
        $getTotalCash = $getTotalAmountCashByMembership + $getTotalAmountCashByAccess + $getTotalAmountCashByPT;
        $getTotalBank = $getTotalAmountBankByMembership + $getTotalAmountBankByAccess + $getTotalAmountBankByPT;
        $getTotalCredit = $getTotalAmountCreditCardByMembership + $getTotalAmountCreditCardByAccess + $getTotalAmountCreditCardByPT;
        $getTotalDebit = $getTotalAmountDebitCardByMembership + $getTotalAmountDebitCardByAccess + $getTotalAmountDebitCardByPT;
        $getTotalGcash = $getTotalAmountGcashByMembership + $getTotalAmountGcashByAccess + $getTotalAmountGcashByPT;
        $getTotalPaymaya = $getTotalAmountPaymayaByMembership + $getTotalAmountPaymayaByAccess + $getTotalAmountPaymayaByPT;
        $getTotalCheck = $getTotalAmountCheckByMembership + $getTotalAmountCheckByAccess + $getTotalAmountCheckByPT;

        $getTotalAmount = $getTotalMembership + $getTotalAccess + $getTotalPT;

        $response[] = [
            'category' => "Gym membership",
            'total_amount' => number_format($getTotalMembership, 2, '.', ','),
            'cash' => number_format($getTotalAmountCashByMembership, 2, '.', ','),
            'bank' => number_format($getTotalAmountBankByMembership, 2, '.', ','),
            'credit' => number_format($getTotalAmountCreditCardByMembership, 2, '.', ','),
            'debit' => number_format($getTotalAmountDebitCardByMembership, 2, '.', ','),
            'gcash' => number_format($getTotalAmountGcashByMembership, 2, '.', ','),
            'paymaya' => number_format($getTotalAmountPaymayaByMembership, 2, '.', ','),
            'check' => number_format($getTotalAmountCheckByMembership, 2, '.', ','),
        ];
        $response[] = [
            'category' => "Gym Access",
            'total_amount' => number_format($getTotalAccess, 2, '.', ','),
            'cash' => number_format($getTotalAmountCashByAccess, 2, '.', ','),
            'bank' => number_format($getTotalAmountBankByAccess, 2, '.', ','),
            'credit' => number_format($getTotalAmountCreditCardByAccess, 2, '.', ','),
            'debit' => number_format($getTotalAmountDebitCardByAccess, 2, '.', ','),
            'gcash' => number_format($getTotalAmountGcashByAccess, 2, '.', ','),
            'paymaya' => number_format($getTotalAmountPaymayaByAccess, 2, '.', ','),
            'check' => number_format($getTotalAmountCheckByAccess, 2, '.', ','),

        ];
        $response[] = [
            'category' => "Coaching",
            'total_amount' => number_format($getTotalPT, 2, '.', ','),
            'cash' => number_format($getTotalAmountCashByPT, 2, '.', ','),
            'bank' => number_format($getTotalAmountBankByPT, 2, '.', ','),
            'credit' => number_format($getTotalAmountCreditCardByPT, 2, '.', ','),
            'debit' => number_format($getTotalAmountDebitCardByPT, 2, '.', ','),
            'gcash' => number_format($getTotalAmountGcashByPT, 2, '.', ','),
            'paymaya' => number_format($getTotalAmountPaymayaByPT, 2, '.', ','),
            'check' => number_format($getTotalAmountCheckByPT, 2, '.', ','),

        ];
        $response[] = [
            'category' => "Total",
            'total_amount' => number_format($getTotalAmount, 2, '.', ','),
            'cash' => number_format($getTotalCash, 2, '.', ','),
            'bank' => number_format($getTotalBank, 2, '.', ','),
            'credit' => number_format($getTotalCredit, 2, '.', ','),
            'debit' => number_format($getTotalDebit, 2, '.', ','),
            'gcash' => number_format($getTotalGcash, 2, '.', ','),
            'paymaya' => number_format($getTotalPaymaya, 2, '.', ','),
            'check' => number_format($getTotalCheck, 2, '.', ','),

        ];

        return $response;
    }

    public function downloadReport()
    {
        $data = [
            'Gym Membership' => $this->getMembershipPlan(),
            'Gym Access' => $this->getAccessPlan(),
            'Coaching' => $this->getCoachingPlan(),
            'Summary' => $this->getSummary(),
        ];

        return redirect()->route('download.report', [
            'branch' => $this->branchLocation,
            'data' => json_encode($data)
        ]);
    }
}
