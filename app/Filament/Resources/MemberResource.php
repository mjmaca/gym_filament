<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Filament\Resources\MemberResource\RelationManagers;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MemberResource extends Resource
{
    protected static ?string $model = Member::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                        Forms\Components\TextInput::make('full_name')
                            ->required(),
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
                        Forms\Components\TextInput::make('emergency_name')
                            ->required(),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->tel()
                            ->required(),
                        Forms\Components\TextInput::make('branch_location')
                            ->required(),
                        Forms\Components\DatePicker::make('birth_date')
                            ->required(),
                    ]),

                Section::make('Gym Membership')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('gym_membership_discount'),
                        Forms\Components\DatePicker::make('gym_membership_expiration_date'),
                        Forms\Components\DatePicker::make('gym_membership_start_date'),
                        Forms\Components\TextInput::make('gym_membership_price'),
                        Forms\Components\TextInput::make('gym_membership_type'),
                        Forms\Components\TextInput::make('gym_membership_extension'),
                    ]),

                Section::make('Gym Access')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('gym_access_discount'),
                        Forms\Components\DatePicker::make('gym_access_expiration_date'),
                        Forms\Components\DatePicker::make('gym_access_start_date'),
                        Forms\Components\TextInput::make('gym_access_price'),
                        Forms\Components\TextInput::make('gym_access_plan'),
                        Forms\Components\TextInput::make('gym_access_extension'),
                    ]),

                Section::make('Personal Training')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('pt_session_coach_name'),
                        Forms\Components\TextInput::make('pt_session_price'),
                        Forms\Components\DatePicker::make('pt_session_expiration_date'),
                        Forms\Components\DatePicker::make('pt_session_start_date'),
                        Forms\Components\TextInput::make('pt_session_extension'),
                        Forms\Components\TextInput::make('pt_session_type'),
                        Forms\Components\TextInput::make('pt_session_total'),
                        Forms\Components\TextInput::make('pt_session_used')
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('emergency_contact')
                    ->label('Emergency Contact')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_location')
                    ->label('Branch Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('birth_date')
                    ->label('Birth Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_discount')
                    ->label('Gym Membership Discount')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_expiration_date')
                    ->label('Gym Membership Expiration Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_start_date')
                    ->label('Gym Membership Start Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_price')
                    ->label('Gym Membership Price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_type')
                    ->label('Gym Membership Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_membership_extension')
                    ->label('Gym Membership Extension')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_discount')
                    ->label('Gym Access Discount')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_expiration_date')
                    ->label('Gym Access Expiration Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_start_date')
                    ->label('Gym Access Start Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_price')
                    ->label('Gym Access Price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_plan')
                    ->label('Gym Access Plan')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('gym_access_extension')
                    ->label('Gym Access Extension')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_coach_name')
                    ->label('PT Session Coach Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_price')
                    ->label('PT Session Price')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_expiration_date')
                    ->label('PT Session Expiration Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_start_date')
                    ->label('PT Session Start Date')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_extension')
                    ->label('PT Session Extension')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_type')
                    ->label('PT Session Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_total')
                    ->label('PT Session Total')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('pt_session_used')
                    ->label('PT Session Used')
                    ->sortable()
                    ->searchable(),
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
            'index' => Pages\ListMembers::route('/'),
            'create' => Pages\CreateMember::route('/create'),
            'edit' => Pages\EditMember::route('/{record}/edit'),
        ];
    }
}