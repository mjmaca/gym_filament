<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RouteRatesResource\Pages;
use App\Filament\Resources\RouteRatesResource\RelationManagers;
use App\Models\RouteRates;
use App\Models\Clients;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class RouteRatesResource extends Resource
{
    protected static ?string $model = RouteRates::class;
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationIcon = 'fas-route';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('unique_identifier')->label('Unique Identifier')->required(),
                        Forms\Components\TextInput::make('shipment_type')->required(),
                        Forms\Components\TextInput::make('route_code')->required(),
                        Forms\Components\TextInput::make('route_description')->required(),
                    ]),

                    
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('clients_id')->relationship('clients', 'name')->label('Client Name'),
                    ]),

                Forms\Components\TextInput::make('category')->required(),                
                Forms\Components\TextInput::make('plant')->required(),
                Forms\Components\TextInput::make('two_way_distance')->required(),
                Forms\Components\TextInput::make('fuel_consumption')->required(),
                Forms\Components\TextInput::make('actual_fuel_consumption')->required(),
                Forms\Components\TextInput::make('pump_price')->required(),
                
                Forms\Components\TextInput::make('total_rates')->required(),
                
                
                Forms\Components\Select::make('truck_type')->options([
                    '10W' => '10W',
                    '40FT' => '40FT',
                ])->default('10W'),
                Forms\Components\Select::make('customer_delivery')->options([
                    'Yes' => 'Yes',
                    'No' => 'No',
                ])->default('No'),
                Forms\Components\TextInput::make('rate_ex_vat')->required(),
                Forms\Components\Datepicker::make('date_period_fuel')->default(now()->format('Y-m-d'))->required(),
                Forms\Components\TextInput::make('rate_fuel_cost')->required(),
                Forms\Components\TextInput::make('start_fuel_period')->required(),
                Forms\Components\TextInput::make('end_fuel_period')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('unique_identifier')->label('Unique Identifier'),
                Tables\Columns\TextColumn::make('route_description')->label('Route Description'),
                Tables\Columns\TextColumn::make('route_code')->label('Route Code'),
                Tables\Columns\TextColumn::make('plant')->label('Plant'),
                Tables\Columns\TextColumn::make('truck_type')->label('Truck Type'),
                Tables\Columns\TextColumn::make('customer_delivery')->label('Customer Delivery'),
                Tables\Columns\TextColumn::make('rate_ex_vat')->label('Rate Ex Vat'),
                Tables\Columns\TextColumn::make('date_period_fuel')->label('Date Period Fuel'),
                Tables\Columns\TextColumn::make('rate_fuel_cost')->label('Rate Fuel Cost'),
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
            'index' => Pages\ListRouteRates::route('/'),
            'create' => Pages\CreateRouteRates::route('/create'),
            'edit' => Pages\EditRouteRates::route('/{record}/edit'),
        ];
    }
}
