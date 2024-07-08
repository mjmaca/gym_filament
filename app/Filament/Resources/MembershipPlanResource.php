<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipPlanResource\Pages;
use App\Filament\Resources\MembershipPlanResource\RelationManagers;
use App\Models\MembershipPlan;
use App\Models\Branch;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group; 

class MembershipPlanResource extends Resource
{
    protected static ?string $model = MembershipPlan::class;

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
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->label('Type'),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->prefix('PHP'),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->label('Duration')
                    ->numeric()
                    ->suffix('months')
                    ->placeholder('Enter the duration in months'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('branch_location')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->prefix('PHP ')
                    ->formatStateUsing(fn($record): string => number_format($record->price, 2, '.', ','))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration (months)')
                    ->suffix(' Months')
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->groups([
                Group::make('branch_location') 
                    ->label('Branch Location')
                    ->collapsible()
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
            'index' => Pages\ListMembershipPlans::route('/'),
            'create' => Pages\CreateMembershipPlan::route('/create'),
            'edit' => Pages\EditMembershipPlan::route('/{record}/edit'),
        ];
    }
}
