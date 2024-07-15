<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupClassResource\Pages;
use App\Filament\Resources\GroupClassResource\RelationManagers;
use App\Models\GroupClass;
use App\Models\Branch;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class GroupClassResource extends Resource
{
    protected static ?string $model = GroupClass::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->columns(1)
                    ->schema([
                        Forms\Components\Checkbox::make('is_member')
                            ->default(false)
                            ->live()
                            ->label("For Member Price?"),
                    ]),

                Forms\Components\Select::make('branch_location')
                    ->options(Branch::all()->pluck('name', 'name'))
                    ->label("Branch Location")
                    ->live()
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->required()
                    ->label('Type')
                    ->placeholder('Enter group class type')
                    ->maxLength(255),

                Forms\Components\TextInput::make('no_group_member')
                    ->required()
                    ->label('Number of Group Members')
                    ->numeric()
                    ->step(1),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->numeric()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('branch_location')
                    ->label('Branch Location')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_group_member')
                    ->label('Number of Group Members')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\BooleanColumn::make('is_member')
                    ->label('For Member')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
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
            'index' => Pages\ListGroupClasses::route('/'),
            'create' => Pages\CreateGroupClass::route('/create'),
            'edit' => Pages\EditGroupClass::route('/{record}/edit'),
        ];
    }
}
