<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoachResource\Pages;
use App\Filament\Resources\CoachResource\RelationManagers;
use App\Models\Coach;
use App\Models\Branch;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoachResource extends Resource
{
    protected static ?string $model = Coach::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('branch_location')
                ->options(Branch::all()->pluck('name', 'name'))
                ->label("Branch Location")
                ->required(),
                Forms\Components\TextInput::make('employee_id')
                    ->label('Employee ID')
                    ->required(),
                Forms\Components\TextInput::make('coach_name')
                    ->label('Coach Name')
                    ->required(),
                Forms\Components\TextInput::make('contact_number')
                    ->prefix('+63')
                    ->label('Mobile Number')
                    ->tel()
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('address')
                    ->label('Address')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            Tables\Columns\TextColumn::make('coach_name')
                ->label('Coach Name')
                ->searchable(),
            Tables\Columns\TextColumn::make('contact_number')
                ->label('Contact Number'),
            Tables\Columns\TextColumn::make('address')
                ->label('Address'),
            Tables\Columns\TextColumn::make('branch_location')
                ->label('Branch Location')
                ->searchable(),
            Tables\Columns\TextColumn::make('employee_id')
                ->label('Employee ID')
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
            'index' => Pages\ListCoaches::route('/'),
            'create' => Pages\CreateCoach::route('/create'),
            'edit' => Pages\EditCoach::route('/{record}/edit'),
        ];
    }
}
