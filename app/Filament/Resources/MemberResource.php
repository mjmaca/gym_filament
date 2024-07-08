<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MemberResource\Pages;
use App\Models\Branch;
use App\Models\Member;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Section::make('')
                            ->columns(1)
                            ->schema([
                                Forms\Components\Checkbox::make('is_guest')
                                    ->default(false)
                                    ->live()
                                    ->label("Is Guest")
                                    ->afterStateUpdated(function (callable $set, $state, $get) {
                                        $branchCode = Branch::where('name', $get('branch_location'))->value('code');
                                        $year = date('Y');
                                        $lastMemberId = Member::latest()->first()->id ?? 0;
                                        $newMemberID = $branchCode . '-' . $year . '-' . $lastMemberId;
                                        if ($state === true) {
                                            $set('membership_id', null);
                                        } else {
                                            $set('membership_id', $newMemberID);
                                        }
                                    }),
                            ]),
                        Forms\Components\Select::make('branch_location')
                            ->options(Branch::all()->pluck('name', 'name'))
                            ->label("Branch Location")
                            ->live()
                            ->required()
                            ->afterStateUpdated(function (callable $set, $state, $get) {
                                $branchCode = Branch::where('name', $state)->value('code');
                                $year = date('Y');
                                $lastMemberId = Member::latest()->first()->id ?? 0;
                                $newMemberID = $branchCode . '-' . $year . '-' . $lastMemberId;
                                if ($get('is_guest') === true) {
                                    $set('membership_id', null);
                                } else {
                                    $set('membership_id', $newMemberID);
                                }
                            }),
                        Forms\Components\TextInput::make('membership_id')
                            ->disabled()
                            ->label("Membership ID"),
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
                        Forms\Components\TextInput::make('occupation')
                            ->default("None"),
                        Forms\Components\TextInput::make('mobile_number')
                            ->prefix('+63')
                            ->label('Mobile Number')
                            ->tel()
                            ->numeric()
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
                            ->label("Emergency Contact Name"),
                        Forms\Components\TextInput::make('emergency_contact')
                            ->tel()
                            ->prefix('+63')
                            ->numeric()
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

                    Tables\Columns\TextColumn::make('branch_location')
                    ->label('Branch Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('mobile_number')
                    ->label('Mobile Number'),
                Tables\Columns\BooleanColumn::make('is_guest')
                    ->label('Is Member')
                    ->sortable()
                    ->searchable()
                    ->getStateUsing(function (Member $record): bool {
                        return !$record->is_guest; // Invert the value
                    }),
                  

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
        ];
    }
}