<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Branch;
use App\Models\Member;
use App\Models\MembershipPlan;
use App\Models\TrainingType;
use App\Models\GymAccessPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('membership_id')
                            ->required()
                            ->unique(Member::class, 'membership_id', fn($record) => $record)
                            ->label("Membership ID"),
                        Forms\Components\Select::make('branch_location')
                            ->options(Branch::all()->pluck('name', 'id'))
                            ->label("Branch Location"),
                        Forms\Components\TextInput::make('full_name')
                            ->required()
                            ->label("Full Name"),
                        Forms\Components\Select::make('gender')
                            ->options([
                                'male' => 'Male',
                                'female' => 'Female',
                                'other' => 'Other'
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('province')
                            ->required(),
                        Forms\Components\TextInput::make('city')
                            ->required(),
                        Forms\Components\TextInput::make('barangay')
                            ->required(),
                        Forms\Components\TextInput::make('street')
                            ->required(),
                        Forms\Components\TextInput::make('occupation'),
                        Forms\Components\TextInput::make('mobile_number')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(Member::class, 'email', fn($record) => $record),
                        Forms\Components\DatePicker::make('birth_date')
                            ->required()
                            ->label("Birth Date"),
                        Forms\Components\TextInput::make('emergency_name')
                            ->required()
                            ->label("Emergency Name"),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->tel()
                            ->label("Emergency Contact Number")
                            ->required(),
                    ]),

                Section::make('Gym Membership')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('gym_membership_type')
                            ->options(MembershipPlan::all()->pluck('description', 'description'))
                            ->label("Plan"),
                        Forms\Components\TextInput::make('gym_membership_price')
                            ->required()
                            ->label("Price"),
                        Forms\Components\DatePicker::make('gym_membership_start_date')
                            ->required()
                            ->label("Start Date"),
                        Forms\Components\DatePicker::make('gym_membership_expiration_date')
                            ->required()
                            ->label("Expiration Date"),
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
                                '70' => '70% ssDiscount',
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
                            ->label('Plan'),
                        Forms\Components\TextInput::make('gym_access_price')
                            ->required()
                            ->label("Price"),
                        Forms\Components\DatePicker::make('gym_access_start_date')
                            ->required()
                            ->label("Start Date"),
                        Forms\Components\DatePicker::make('gym_access_expiration_date')
                            ->required()
                            ->label("Expiration Date"),
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
                                '70' => '70% ssDiscount',
                            ]),
                        Forms\Components\Select::make('gym_access_extension')
                            ->required()
                            ->label("Gym Access Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Month Extension',
                                '2' => '2 Month Extension',
                            ]),
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
                            ->required()
                            ->label("Session Extension")
                            ->options([
                                '0' => 'No Extension',
                                '1' => '1 Session',
                                '2' => '2 Session',
                                '3' => '2 Session',
                                '4' => '2 Session',
                                '5' => '2 Session',

                            ]),
                        Forms\Components\TextInput::make('pt_session_used')
                            ->numeric()
                            ->label('Sessions Used')
                            ->default(0)
                            ->disabled(true),
                    ]),


                Section::make('Payment')
                    ->columns(2)
                    ->hiddenOn('edit')
                    ->schema([
                        Forms\Components\Select::make('payment_method')
                            ->required()
                            ->options([
                                'Bank Transfer' => 'Bank Transfer',
                                'Cash' => 'Cash',
                                'Credit Card' => 'Credit Card',
                                'Debit Card' => 'Debit Card',
                                'Gcash' => 'Gcash',
                                'Paymaya' => 'Paymaya',
                            ]),
                        Forms\Components\TextInput::make('amount')
                            ->required()


                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('membership_id')
                    ->label('Membership ID')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_type')
                    ->label('Gym Membership Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_plan')
                    ->label('Gym Access Plan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_type')
                    ->label('PT Session Type')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make("Renew")
                    ->label('Renew'),
                // ->url('renew'),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
            'renew' => Pages\Renew::route('/{record}/renew'),
        ];
    }
}