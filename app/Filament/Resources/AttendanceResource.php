<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;


class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel  = "Daily Attendances";
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
                            }),

                        Section::make('Membership Details')
                            ->columns(2)
                            ->hidden(fn($get) => !$get('selectedMember'))
                            ->schema([
                                Forms\Components\Placeholder::make('full_name')
                                    ->label('Full Name')
                                    ->content(fn($get) => $get('selectedMember.full_name')),
                                Forms\Components\Placeholder::make('email')
                                    ->label('Email')
                                    ->content(fn($get) => $get('selectedMember.email')),
                                Forms\Components\Placeholder::make('mobile_number')
                                    ->label('Mobile Number')
                                    ->content(fn($get) => $get('selectedMember.mobile_number')),
                                Forms\Components\Placeholder::make('branch_location')
                                    ->label('Branch Location')
                                    ->content(fn($get) => $get('selectedMember.branch_location'))
                            ]),
                    ]),
            ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Full Name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_location')
                    ->label('Branch Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_guest')
                    ->label('Is Guest')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            // 'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
