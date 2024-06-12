<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingTypeResource\Pages;
use App\Filament\Resources\TrainingTypeResource\RelationManagers;
use App\Models\TrainingType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TrainingTypeResource extends Resource
{
    protected static ?string $model = TrainingType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('description')
                    ->required()
                    ->label('Description'),

                Forms\Components\Repeater::make('sessions')
                    ->schema([
                        Forms\Components\TextInput::make('number_sessions')
                            ->required()
                            ->label('Session'),
                        Forms\Components\TextInput::make('duration')
                            ->required()
                            ->label('Session Expiration Duration (days)'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->label('Price'),
                    ])
                    ->label('Sessions')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
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
            'index' => Pages\ListTrainingTypes::route('/'),
            'create' => Pages\CreateTrainingType::route('/create'),
            'edit' => Pages\EditTrainingType::route('/{record}/edit'),
        ];
    }
}
