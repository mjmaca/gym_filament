<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use App\Models\Member;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Actions\ButtonAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
// use Filament\Forms\Components\Actions\Action;
use Filament\Actions\Action;
use Filament\Navigation;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

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
                            }),

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
                            ]),
                    ]),

                // Forms\Components\Actions::make([
                //     Forms\Components\Actions\Action::make('Create')
                //     ->action(function ($get) {
                //             $attendance = new Attendance();
                //             $attendance->member_id = $get('selectedMember.id');
                //             $attendance->save();
                //     })
                //     ->disabled(fn($get) => !$get('selectedMember')),
                // ]),
            ]);
        // ->mutateFormDataBeforeCreate(function ($get) {
        //     $attendance = new Attendance();
        //     $attendance->membership_id = $get('selectedMember.membership_id');
        //     $attendance->member_id = $get('selectedMember.id');
        //     $attendance->branch_location = $get('selectedMember.branch_location');
        //     $attendance->fullname = $get('selectedMember.fullname');
        //     $attendance->is_guest = $get('selectedMember.is_guest');

        //     logger('Data:::'. $attendance);
        //     return $attendance;
        // });
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
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            // 'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }
}
