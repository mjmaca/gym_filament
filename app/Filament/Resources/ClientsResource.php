<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientsResource\Pages;
use App\Models\Clients;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ClientsResource extends Resource
{
    protected static ?string $model = Clients::class;
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationIcon = 'heroicon-s-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // TextInput::make('id')->default(fn() => (string) Str::uuid()),
                TextInput::make('name')->required(),
                TextInput::make('acronym')->required(),
                TextInput::make('address')->required(),
                TextInput::make('tin')->required(),
                TextInput::make('vendor_code')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Client Name')->searchable(),
                Tables\Columns\TextColumn::make('acronym')->label('Acronym'),
                Tables\Columns\TextColumn::make('address')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('tin')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('vendor_code')->sortable()->searchable(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClients::route('/create'),
            'edit' => Pages\EditClients::route('/{record}/edit'),
        ];
    }
}
