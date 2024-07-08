<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingTypeResource\Pages;
use App\Models\Branch;

use App\Models\TrainingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group; 


class TrainingTypeResource extends Resource
{
    protected static ?string $model = TrainingType::class;

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
                    ->label('Description')
                    ->required(),
                Forms\Components\TextInput::make('session_number')
                    ->label('Session Number')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('session_price')
                    ->label('Session Price')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('session_duration')
                    ->label('Session Duration')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup('branch_location')
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session_number')
                    ->label('Session Number')
                    ->suffix(' Session')
                    ->searchable(),
                Tables\Columns\TextColumn::make('session_price')
                    ->label('Session Price')
                    ->prefix('PHP ')
                    ->formatStateUsing(fn($record): string => number_format($record->session_price, 2, '.', ','))
                    ->searchable(),
                Tables\Columns\TextColumn::make('session_duration')
                    ->suffix(' Days')
                    ->label('Session Expiration Duration')
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
            'index' => Pages\ListTrainingTypes::route('/'),
            'create' => Pages\CreateTrainingType::route('/create'),
            'edit' => Pages\EditTrainingType::route('/{record}/edit'),
        ];
    }
}
