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

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Checkbox::make('is_guest')
                            ->default(false)
                            ->label("Is Guest"),

                        Forms\Components\TextInput::make('membership_id')
                            ->unique(Member::class, 'membership_id', fn($record) => $record)
                            ->label("Membership ID"),
                        Forms\Components\Select::make('branch_location')
                            ->options(Branch::all()->pluck('name', 'name'))
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
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('membership_id')
                    ->label('Membership Id'),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number'),
                Tables\Columns\BooleanColumn::make('is_guest')
                    ->label('Is Guest')
                    ->sortable()
                    ->searchable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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