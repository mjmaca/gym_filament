<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GymAccessPlanResource\Pages;
use App\Filament\Resources\GymAccessPlanResource\RelationManagers;
use App\Models\GymAccessPlan;
use App\Models\Branch;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GymAccessPlanResource extends Resource
{
    protected static ?string $model = GymAccessPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Forms\Components\Select::make('branch_location')
                    ->options(Branch::all()->pluck('name', 'name'))
                    ->label("Branch Location")
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->label('Description')
                    ->placeholder('Enter the plan description')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->numeric()
                    ->placeholder('Enter the price in dollars'),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->label('Duration')
                    ->numeric()
                    ->suffix('days')
                    ->placeholder('Enter the duration in days'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('branch_location')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->sortable()
                    ->prefix('PHP ')
                    ->formatStateUsing(fn($record): string => number_format($record->price, 2, '.', ','))
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration (days)')
                    ->suffix(' Days')
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
            'index' => Pages\ListGymAccessPlans::route('/'),
            'create' => Pages\CreateGymAccessPlan::route('/create'),
            'edit' => Pages\EditGymAccessPlan::route('/{record}/edit'),
        ];
    }
}
