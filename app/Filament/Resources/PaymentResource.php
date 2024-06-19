<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use Carbon\Carbon;

use App\Models\GymAccessPlan;
use App\Models\MembershipPlan;
use App\Models\Payment;
use App\Models\Member;
use App\Models\TrainingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public $selectedMember;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Search Member Name')
                    ->schema([
                        Forms\Components\Select::make('membership_id')
                            ->options(Member::all()->pluck('full_name', 'id'))
                            ->label("Membership Name")
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $member = Member::where('id', $state)->firstOrFail();
                                $set('selectedMember', $member);

                                if ($member) {
                                    //set the gym membership plan if exist in member profile
                                    $set('gym_membership_type', $member->gym_membership_type);
                                    $set('gym_membership_price', $member->gym_membership_price);
                                    $set('gym_membership_discount', $member->gym_membership_discount);
                                    $set('gym_membership_extension', $member->gym_membership_extension);
                                    //Format to display the current data in form
                                    // $set('gym_membership_start_date', $member->gym_membership_start_date ? Carbon::parse($member->gym_membership_start_date)->format('Y-m-d') : null);
                    
                                    //set the gym access plan if exist in member profile
                                    $set('gym_access_plan', $member->gym_access_plan);
                                    $set('gym_access_price', $member->gym_access_price);
                                    $set('gym_access_discount', $member->gym_access_discount);
                                    $set('gym_access_extension', $member->gym_access_extension);

                                    //set the training type plan if exist in member profile
                                    $set('pt_session_coach_name', $member->pt_session_coach_name);
                                    $set('pt_session_type', $member->pt_session_type);
                                    $set('pt_session_total', $member->pt_session_total);
                                    $set('pt_session_price', $member->pt_session_price);
                                    $set('pt_session_extension', $member->pt_session_extension);
                                }
                            }),

                        // // //Membership Details
                        Section::make('Membership Details')
                            ->columns(2)
                            ->hidden(fn($get) => !$get('selectedMember'))
                            ->schema([
                                Forms\Components\Placeholder::make('membership_id')
                                    ->label('Membership ID')
                                    ->content(fn($get) => $get('selectedMember.membership_id') ?? 'Non Member'),
                                Forms\Components\Placeholder::make('full_name')
                                    ->label('Full Name')
                                    ->content(fn($get) => $get('selectedMember.full_name') ?? 'N/A')
                                    ->hidden(fn($get) => !$get('selectedMember')),
                                Forms\Components\Placeholder::make('email')
                                    ->label('Email')
                                    ->content(fn($get) => $get('selectedMember.email') ?? 'N/A'),
                                Forms\Components\Placeholder::make('branch_location')
                                    ->label('Branch Location')
                                    ->content(fn($get) => $get('selectedMember.branch_location') ?? 'N/A'),
                                Forms\Components\Placeholder::make('gym_membership_start_date')
                                    ->label('Gym Membership Start Date')
                                    ->content(fn($get) => $get('selectedMember.gym_membership_start_date') ?? 'N/A'),
                                Forms\Components\Placeholder::make('gym_membership_expiration_date')
                                    ->label('Gym Membership End Date')
                                    ->content(fn($get) => $get('selectedMember.gym_membership_expiration_date') ?? 'N/A'),
                                Forms\Components\Placeholder::make('gym_access_start_date')
                                    ->label('Gym Access Start Date')
                                    ->content(fn($get) => $get('selectedMember.gym_access_start_date') ?? 'N/A'),
                                Forms\Components\Placeholder::make('c')
                                    ->label('Gym Access End Date')
                                    ->content(fn($get) => $get('selectedMember.gym_access_start_date') ?? 'N/A'),
                                Forms\Components\Placeholder::make('pt_session_start_date')
                                    ->label('PT Session Start Date')
                                    ->content(fn($get) => $get('selectedMember.pt_session_start_date') ?? 'N/A'),
                                Forms\Components\Placeholder::make('pt_session_expiration_date')
                                    ->label('PT Session End Date')
                                    ->content(fn($get) => $get('selectedMember.pt_session_expiration_date') ?? 'N/A'),

                            ]),
                    ]),


                Section::make('Gym Membership')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gym_membership_type')
                            ->options(MembershipPlan::all()->pluck('type', 'type'))
                            ->label("Gym Membership Type")
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                $price = MembershipPlan::where('type', $state)->value('price');
                                $set('gym_membership_price', $price);
                                //set the current total amount when the field change
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),
                        Forms\Components\TextInput::make('gym_membership_price')
                            ->label("Gym Membership Price")
                            ->numeric()
                            ->prefix("PHP")
                            ->disabled(),
                        Forms\Components\Select::make('gym_membership_discount')
                            ->label("Discount")
                            ->live()
                            ->options([
                                '0' => 'Free Trial Workout',
                                '5' => '5% Discount',
                                '10' => '10% Discount',
                                '15' => '15% Discount',
                                '20' => '20% Discount',
                                '25' => '25% Discount',
                                '30' => '30% Discount',
                                '35' => '35% Discount',
                                '40' => '40% Discount',
                                '45' => '45% Discount',
                                '50' => '50% Discount',
                                '55' => '55% Discount',
                                '60' => '60% Discount',
                                '65' => '65% Discount',
                                '70' => '70% Discount',
                            ])
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                //set the current total amount when the field change
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),
                        Forms\Components\Select::make('gym_membership_extension')
                            ->label("Membership Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Month Extension',
                                '2' => '2 Month Extension',
                            ]),
                        Forms\Components\DatePicker::make('gym_membership_start_date')
                            ->label("Gym Membership Start Date")
                            ->default(now()->format('Y-m-d')),
                        Forms\Components\DatePicker::make('gym_membership_expiration_date')
                            ->label("Gym Membership Expiration Date")
                    ]),

                Section::make('Gym Access')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gym_access_plan')
                            ->options(GymAccessPlan::all()->pluck('description', 'description'))
                            ->label("Gym Access Plan")
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                $price = GymAccessPlan::where('description', $state)->value('price');
                                $set('gym_access_price', $price);
                                //set the current total amount when the field change
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),
                        Forms\Components\TextInput::make('gym_access_price')
                            ->label("Gym Access Price")
                            ->numeric()
                            ->prefix("PHP")
                            ->disabled(),
                        Forms\Components\Select::make('gym_access_discount')
                            ->required()
                            ->live()
                            ->label("Discount")
                            ->options([
                                '0' => 'Free Trial Workout',
                                '5' => '5% Discount',
                                '10' => '10% Discount',
                                '15' => '15% Discount',
                                '20' => '20% Discount',
                                '25' => '25% Discount',
                                '30' => '30% Discount',
                                '35' => '35% Discount',
                                '40' => '40% Discount',
                                '45' => '45% Discount',
                                '50' => '50% Discount',
                                '55' => '55% Discount',
                                '60' => '60% Discount',
                                '65' => '65% Discount',
                                '70' => '70% Discount',
                            ])
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                //set the current total amount when the field change
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),
                        Forms\Components\Select::make('gym_access_extension')
                            ->required()
                            ->label("Membership Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Month Extension',
                                '2' => '2 Month Extension',
                            ]),
                        Forms\Components\DatePicker::make('gym_access_start_date')
                            ->label("Gym Access Start Date")
                            ->required()
                            ->default(now()->format('Y-m-d')),
                        Forms\Components\DatePicker::make('gym_access_expiration_date')
                            ->required()
                            ->label("Gym Access Expiration Date"),
                    ]),

                Section::make('Personal Training')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pt_session_coach_name')
                            ->label('Coach Name'),
                        Forms\Components\Select::make('pt_session_type')
                            ->options(TrainingType::all()->pluck('description', 'description'))
                            ->label('Session Type')
                            ->live(),
                        Forms\Components\Select::make('pt_session_total')
                            ->label('Number of Sessions')
                            ->options(fn(Forms\Get $get) => TrainingType::where('description', $get('pt_session_type'))->pluck('session_number', 'session_number'))
                            ->disabled(fn(Forms\Get $get): bool => !filled($get('pt_session_type')))
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                $price = TrainingType::where('session_number', $state)->value('session_price');
                                $set('pt_session_price', $price);
                                //set the current total amount when the field change
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),
                        Forms\Components\TextInput::make('pt_session_price')
                            ->label("Session Price")
                            ->numeric()
                            ->prefix("PHP")
                            ->disabled(),
                        Forms\Components\Select::make('pt_session_extension')
                            ->label("Session Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Session',
                                '2' => '2 Session',
                                '3' => '3 Session',
                                '4' => '4 Session',
                                '5' => '5 Session',

                            ]),
                        Forms\Components\TextInput::make('pt_session_used')
                            ->numeric()
                            ->label('Sessions Used')
                            ->default(0)
                            ->disabled(true),
                        Forms\Components\DatePicker::make('pt_session_expiration_date')
                            ->label('Expiration Date'),
                        Forms\Components\DatePicker::make('pt_session_start_date')
                            ->label('Start Date'),

                    ]),

                Section::make('Payment')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->label("Payment Method")
                            ->options([
                                'cash' => 'Cash',
                                'credit_card' => 'Credit Card',
                                'online_payment' => 'Online Payment',
                            ])
                            ->live()
                            ->afterStateUpdated(function (callable $set, $get) {
                                // Call calculateTotalAmount function from PaymentResource class
                                $totalAmount = self::calculateTotalAmount($get);
                                $set('amount', $totalAmount);
                            }),

                        Forms\Components\TextInput::make('amount')
                            ->required()
                            ->numeric()
                            ->disabled()
                            ->prefix('PHP')
                            ->label("Amount"),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date'),
                Tables\Columns\TextColumn::make('membership_id')
                    ->label('Membership Id'),
                Tables\Columns\TextColumn::make('membership_id')
                    ->label('Membership Id'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name'),
                Tables\Columns\TextColumn::make('branch_location')
                    ->label('Branch Location'),
                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Payment Method'),
                Tables\Columns\TextColumn::make('amount')
                    ->label('Amount'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function calculateTotalAmount($get)
    {
        $gymMembershipPrice = $get('gym_membership_price') ?? 0;
        $gymAccessPrice = $get('gym_access_price') ?? 0;
        $ptSessionPrice = $get('pt_session_price') ?? 0;

        $gymMembershipDiscount = $get('gym_membership_discount') ?? 0;
        $gymAccessDiscount = $get('gym_access_discount') ?? 0;
        logger("member".$gymMembershipDiscount);
        logger("access".$gymAccessDiscount);

        $totalMembershipPrice = $gymMembershipPrice - ($gymMembershipPrice * (($gymMembershipDiscount / 100)));
        $totalAccessPrice = $gymAccessPrice - ($gymAccessPrice * (($gymAccessDiscount / 100)));
        $totalPTPrice = $ptSessionPrice;

        $totalAmount = $totalMembershipPrice + $totalAccessPrice + $totalPTPrice;
        logger($totalAmount);
        return round($totalAmount, 2); // Return rounded total amount to 2 decimal places
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            // 'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
