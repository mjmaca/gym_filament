<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
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
                            ->options(Member::all()->pluck('full_name', 'membership_id'))
                            ->label("Membership ID")
                            ->searchable()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (callable $set, $state) {
                                $member = Member::where('membership_id', $state)->firstOrFail();
                                $set('selectedMember', $member);
                            }),


                        // //Membership Details
                        Forms\Components\Placeholder::make('membership_id')
                            ->label('Membership ID')
                            ->content(fn($get) => $get('selectedMember.membership_id') ?? 'N/A')
                            ->hidden(fn($get) => !$get('selectedMember')),
                        Forms\Components\Placeholder::make('mobile_number')
                            ->label('Mobile Number')
                            ->content(fn($get) => $get('selectedMember.mobile_number') ?? 'N/A')
                            ->hidden(fn($get) => !$get('selectedMember')),
                        Forms\Components\Placeholder::make('full_name')
                            ->label('Full Name')
                            ->content(fn($get) => $get('selectedMember.full_name') ?? 'N/A')
                            ->hidden(fn($get) => !$get('selectedMember')),
                        Forms\Components\Placeholder::make('email')
                            ->label('Email')
                            ->content(fn($get) => $get('selectedMember.email') ?? 'N/A')
                            ->hidden(fn($get) => !$get('selectedMember')),
                        Forms\Components\Placeholder::make('branch_location')
                            ->label('branch_location')
                            ->content(fn($get) => $get('selectedMember.branch_location') ?? 'N/A')
                            ->hidden(fn($get) => !$get('selectedMember')),

                    ]),
                Section::make('Gym Membership')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gym_membership_type')
                            ->options(MembershipPlan::all()->pluck('description', 'description'))
                            ->label("Gym Membership Type")
                            ->live(),
                        Forms\Components\Select::make('gym_membership_price')
                            ->label("Gym Membership Price")
                            ->options(fn(Forms\Get $get) => MembershipPlan::where('description', $get('gym_membership_type'))->pluck('price', 'price'))
                            ->disabled(fn(Forms\Get $get): bool => !filled($get('gym_membership_type'))),

                        Forms\Components\DatePicker::make('gym_membership_start_date')
                            ->label("Gym Membership Start Date")
                            ->default(now()->format('Y-m-d')),
                        Forms\Components\DatePicker::make('gym_membership_expiration_date')
                            ->label("Gym Membership Expiration Date"),
                        Forms\Components\Select::make('gym_membership_discount')
                            ->required()
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
                            ]),
                        Forms\Components\Select::make('gym_membership_extension')
                            ->required()
                            ->label("Membership Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Month Extension',
                                '2' => '2 Month Extension',
                            ]),
                    ]),
                Section::make('Gym Access')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gym_access_plan')
                            ->options(GymAccessPlan::all()->pluck('description', 'description'))
                            ->label("Gym Access Plan")
                            ->live(),
                        Forms\Components\Select::make('gym_access_price')
                            ->label("Gym Access Price")
                            ->options(fn(Forms\Get $get) => GymAccessPlan::where('description', $get('gym_access_plan'))->pluck('price', 'price'))
                            ->disabled(fn(Forms\Get $get): bool => !filled($get('gym_access_plan'))),
                        Forms\Components\Select::make('gym_access_discount')
                            ->required()
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
                            ]),
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
                            ->default(now()->format('Y-m-d')),
                        Forms\Components\DatePicker::make('gym_access_expiration_date')
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
                            ->live(),
                        Forms\Components\Select::make('pt_session_price')
                            ->label('Price')
                            ->options(fn(Forms\Get $get) => TrainingType::where('session_number', $get('pt_session_total'))->pluck('session_price', 'session_price'))
                            ->disabled(fn(Forms\Get $get): bool => !filled($get('pt_session_total'))),
                        Forms\Components\DatePicker::make('pt_session_expiration_date')
                            ->label('Expiration Date'),
                        Forms\Components\DatePicker::make('pt_session_start_date')
                            ->label('Start Date'),
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
                    ]),
                Section::make('Payment')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->options([
                                'cash' => 'Cash',
                                'credit_card' => 'Credit Card',
                                'online_payment' => 'Online Payment',
                            ])
                            ->label("Payment Method"),
                        Forms\Components\TextInput::make('amount')
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
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
