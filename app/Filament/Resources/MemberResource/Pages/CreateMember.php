<?php

namespace App\Filament\Resources\MemberResource\Pages;

use App\Filament\Resources\MemberResource;

use App\Models\Payment;
use App\Models\Member;
use App\Models\Branch;
use App\Models\MembershipPlan;
use App\Models\GymAccessPlan;
use App\Models\TrainingType;

use Filament\Resources\Pages\CreateRecord;
use Filament\Forms\Components\Section;

use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Card;

class CreateMember extends CreateRecord
{
    // use CreateRecord\Concerns\HasWizard;
    protected static string $resource = MemberResource::class;

    // protected function getSteps(): array
    // {
    //     return [

    //         // MEMBERSHIP PROFILE
    //         Step::make('Membership Profile')
    //             ->schema([
    //                 Forms\Components\TextInput::make('membership_id')
    //                     ->required()
    //                     ->unique(Member::class, 'membership_id', fn ($record) => $record)
    //                     ->label("Membership ID"),
    //                 Forms\Components\Select::make('branch_location')
    //                     ->options(Branch::all()->pluck('name', 'id'))
    //                     ->label("Branch Location"),
    //                 Forms\Components\TextInput::make('full_name')
    //                     ->required()
    //                     ->label("Full Name"),
    //                 Forms\Components\Select::make('gender')
    //                     ->options([
    //                         'male' => 'Male',
    //                         'female' => 'Female',
    //                         'other' => 'Other'
    //                     ])
    //                     ->required(),
    //                 Forms\Components\TextInput::make('province')
    //                     ->required(),
    //                 Forms\Components\TextInput::make('city')
    //                     ->required(),
    //                 Forms\Components\TextInput::make('barangay')
    //                     ->required(),
    //                 Forms\Components\TextInput::make('street')
    //                     ->required(),
    //                 Forms\Components\TextInput::make('occupation'),
    //                 Forms\Components\TextInput::make('mobile_number')
    //                     ->tel()
    //                     ->required(),
    //                 Forms\Components\TextInput::make('email')
    //                     ->email()
    //                     ->required()
    //                     ->unique(Member::class, 'email', fn ($record) => $record),
    //                 Forms\Components\DatePicker::make('birth_date')
    //                     ->required()
    //                     ->label("Birth Date"),
    //                 Forms\Components\TextInput::make('emergency_name')
    //                     ->required()
    //                     ->label("Emergency Name"),
    //                 Forms\Components\TextInput::make('emergency_contact')
    //                     ->tel()
    //                     ->label("Emergency Contact Number")
    //                     ->required(),
    //             ]),

    //         // GYM DETAILS
    //         Step::make('Gym Details')
    //             ->schema([

    //                 Section::make('Gym Membership')
    //                     ->columns(2)
    //                     ->schema([
    //                         Forms\Components\Select::make('gym_membership_type')
    //                             ->options(MembershipPlan::all()->pluck('description', 'description'))
    //                             ->label("Plan"),
    //                         Forms\Components\TextInput::make('gym_membership_price')
    //                             ->required()
    //                             ->label("Price"),
    //                         Forms\Components\DatePicker::make('gym_membership_start_date')
    //                             ->required()
    //                             ->label("Start Date"),
    //                         Forms\Components\DatePicker::make('gym_membership_expiration_date')
    //                             ->required()
    //                             ->label("Expiration Date"),
    //                         Forms\Components\Select::make('gym_membership_discount')
    //                             ->required()
    //                             ->label("Discount")
    //                             ->options([
    //                                 '0' => 'Free Trial Workout',
    //                                 '5' => '5% Discount',
    //                                 '10' => '10% Discount',
    //                                 '15' => '15% Discount',
    //                                 '20' => '20% Discount',
    //                                 '25' => '25% Discount',
    //                                 '30' => '30% Discount',
    //                                 '35' => '35% Discount',
    //                                 '40' => '40% Discount',
    //                                 '45' => '45% Discount',
    //                                 '50' => '50% Discount',
    //                                 '55' => '55% Discount',
    //                                 '60' => '60% Discount',
    //                                 '65' => '65% Discount',
    //                                 '70' => '70% ssDiscount',
    //                             ]),
    //                         Forms\Components\Select::make('gym_membership_extension')
    //                             ->required()
    //                             ->label("Membership Extension")
    //                             ->options([
    //                                 '0' => 'No Extension',
    //                                 '1' => '1 Month Extension',
    //                                 '2' => '2 Month Extension',
    //                             ]),

    //                     ]),

    //                 Section::make('Gym Access')
    //                     ->columns(2)
    //                     ->schema([
    //                         Forms\Components\Select::make('gym_access_plan')
    //                             ->options(GymAccessPlan::all()->pluck('description', 'description'))
    //                             ->label('Plan'),
    //                         Forms\Components\TextInput::make('gym_access_price')
    //                             ->required()
    //                             ->label("Price"),
    //                         Forms\Components\DatePicker::make('gym_access_start_date')
    //                             ->required()
    //                             ->label("Start Date"),
    //                         Forms\Components\DatePicker::make('gym_access_expiration_date')
    //                             ->required()
    //                             ->label("Expiration Date"),
    //                         Forms\Components\Select::make('gym_access_discount')
    //                             ->required()
    //                             ->label("Discount")
    //                             ->options([
    //                                 '0' => 'Free Trial Workout',
    //                                 '5' => '5% Discount',
    //                                 '10' => '10% Discount',
    //                                 '15' => '15% Discount',
    //                                 '20' => '20% Discount',
    //                                 '25' => '25% Discount',
    //                                 '30' => '30% Discount',
    //                                 '35' => '35% Discount',
    //                                 '40' => '40% Discount',
    //                                 '45' => '45% Discount',
    //                                 '50' => '50% Discount',
    //                                 '55' => '55% Discount',
    //                                 '60' => '60% Discount',
    //                                 '65' => '65% Discount',
    //                                 '70' => '70% ssDiscount',
    //                             ]),
    //                         Forms\Components\Select::make('gym_access_extension')
    //                             ->required()
    //                             ->label("Gym Access Extension")
    //                             ->options([
    //                                 '0' => 'No Extension',
    //                                 '1' => '1 Month Extension',
    //                                 '2' => '2 Month Extension',
    //                             ]),
    //                     ]),

    //                 Section::make('Personal Training')
    //                     ->columns(2)
    //                     ->schema([
    //                         Forms\Components\TextInput::make('pt_session_coach_name')
    //                             ->label('Coach Name'),
    //                         Forms\Components\Select::make('pt_session_type')
    //                             ->options(TrainingType::all()->pluck('description', 'description'))
    //                             ->label('Session Type')
    //                             ->live(),
    //                         Forms\Components\Select::make('pt_session_total')
    //                             ->label('Number of Sessions')
    //                             ->options(fn (Forms\Get $get) => TrainingType::where('description', $get('pt_session_type'))->pluck('session_number', 'session_number'))
    //                             ->disabled(fn (Forms\Get $get): bool => !filled($get('pt_session_type')))
    //                             ->live(),

    //                         Forms\Components\Select::make('pt_session_price')
    //                             ->label('Price')
    //                             ->options(fn (Forms\Get $get) => TrainingType::where('session_number', $get('pt_session_total'))->pluck('session_price', 'session_price'))
    //                             ->disabled(fn (Forms\Get $get): bool => !filled($get('pt_session_total'))),

    //                         Forms\Components\DatePicker::make('pt_session_expiration_date')
    //                             ->label('Expiration Date'),
    //                         Forms\Components\DatePicker::make('pt_session_start_date')
    //                             ->label('Start Date'),
    //                         Forms\Components\TextInput::make('pt_session_extension')
    //                             ->numeric()
    //                             ->label('Extension'),
    //                         Forms\Components\TextInput::make('pt_session_used')
    //                             ->numeric()
    //                             ->label('Sessions Used')
    //                             ->default(0)
    //                             ->disabled(true),
    //                     ]),
    //             ]),

    //         // PAYMENT STEP
    //         Step::make('Payment')
    //             ->schema([
    //                 Section::make('Payment')
    //                     ->columns(2)
    //                     ->schema([
    //                         Forms\Components\Select::make('payment_method')
    //                             ->required()
    //                             ->options([
    //                                 'Bank Transfer' => 'Bank Transfer',
    //                                 'Cash' => 'Cash',
    //                                 'Credit Card' => 'Credit Card',
    //                                 'Debit Card' => 'Debit Card',
    //                                 'Gcash' => 'Gcash',
    //                                 'Paymaya' => 'Paymaya',
    //                             ]),
    //                         Forms\Components\TextInput::make('amount')
    //                             ->required(),
    //                     ]),
    //             ]),


    //     ];
    // }

    // protected function afterCreate()
    // {
    //     $payment = new Payment();
    //     $payment->membership_id = $this->record->membership_id;
    //     $payment->gym_access_discount = $this->record->gym_access_discount;
    //     $payment->gym_access_expiration_date = $this->record->gym_access_expiration_date;
    //     $payment->gym_access_start_date = $this->record->gym_access_start_date;
    //     $payment->gym_access_price = $this->record->gym_access_price;
    //     $payment->gym_access_plan = $this->record->gym_access_plan;
    //     $payment->gym_access_extension = $this->record->gym_access_extension;

    //     $payment->gym_membership_discount = $this->record->gym_membership_discount;
    //     $payment->gym_membership_expiration_date = $this->record->gym_membership_expiration_date;
    //     $payment->gym_membership_start_date = $this->record->gym_membership_start_date;
    //     $payment->gym_membership_price = $this->record->gym_membership_price;
    //     $payment->gym_membership_type = $this->record->gym_membership_type;
    //     $payment->gym_membership_extension = $this->record->gym_membership_extension;

    //     $payment->pt_session_coach_name = $this->record->pt_session_coach_name;
    //     $payment->pt_session_price = $this->record->pt_session_price;
    //     $payment->pt_session_expiration_date = $this->record->pt_session_expiration_date;
    //     $payment->pt_session_start_date = $this->record->pt_session_start_date;
    //     $payment->pt_session_extension = $this->record->pt_session_extension;
    //     $payment->pt_session_type = $this->record->pt_session_type;
    //     $payment->pt_session_total = $this->record->pt_session_total;
    //     $payment->pt_session_used = $this->record->pt_session_used ?? 0;

    //     $payment->payment_method = $this->record->payment_method;
    //     $payment->amount = $this->record->amount;
    //     $payment->save();
    // }
}
