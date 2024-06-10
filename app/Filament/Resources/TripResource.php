<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TripResource\Pages;
use App\Models\Trip;
use Filament\Forms\Form;
use Forms\Components\Repeater;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput as MoneyInput;

class TripResource extends Resource
{
    protected static ?string $model = Trip::class;
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('clients_id')->relationship('clients', 'name')->label('Client Name'),
                Forms\Components\Select::make('status')->options([
                    'scheduled' => 'Scheduled',
                    'in_transit' => 'In Transit',
                    'arrived' => 'Arrived',
                    'completed' => 'Completed',
                    'delayed' => 'Delayed',
                    'on_hold' => 'On Hold',
                    'cancelled' => 'Cancelled',
                    'problematic' => 'Problematic',
                    'pending_approval' => 'Pending Approval',
                    'en_route_to_pickup' => 'En Route to Pickup',
                    'en_route_to_delivery' => 'En Route to Delivery',
                    'out_for_delivery' => 'Out for Delivery',
                ])->default('pending')->required(),
                Forms\Components\Datepicker::make('billed_date')->required(),
                Forms\Components\Select::make('billing_status')->options([
                    'underbilling' => 'Underbilling',
                    'billed' => 'Billed',
                ])->default('underbilling')->required(),

                Section::make('Driver and Truck Details')
                    ->schema([
                        Forms\Components\TextInput::make('trip_no')->required(),
                        Forms\Components\TextInput::make('plate_no')->required(),
                        Forms\Components\TextInput::make('driver_name')->required(),
                        Forms\Components\TextInput::make('helper_name')->required(),
                        MoneyInput::make('budget')
                            ->prefix('PHP')
                            ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),      
                    ])
                    ->columns(2),
                
                Section::make('List of Trips')
                    ->schema([
                        Forms\Components\Repeater::make('items')->label('Trip Details')
                        ->schema([
                            Forms\Components\Datepicker::make('trip_date')->required()->label('Trip Date'),
                            Forms\Components\TextInput::make('origin'),
                            Forms\Components\TextInput::make('destination'),
                            Forms\Components\TextInput::make('voucher_id'),
                            Forms\Components\TextInput::make('delivery_receipt_id'),
                            Forms\Components\TextInput::make('pallet_issuance_id'),
                            Forms\Components\TextInput::make('waybill_id'),
                            MoneyInput::make('toll_fee')
                                ->prefix('PHP')
                                ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                            MoneyInput::make('lagay')
                                ->prefix('PHP')
                                ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                            MoneyInput::make('passway')
                                ->prefix('PHP')
                                ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                            MoneyInput::make('others')
                                ->prefix('PHP')
                                ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                        ])
                        ->columns(5)
                        ->addActionLabel('Add More Trips')
                    ]),
                    
                MoneyInput::make('total_expenses')
                    ->prefix('PHP')
                    ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                MoneyInput::make('cash_return')
                    ->prefix('PHP')
                    ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),
                MoneyInput::make('total_toll_fee')
                    ->prefix('PHP') 
                    ->currencyMask(thousandSeparator: ',',decimalSeparator: '.',precision: 2),

                Forms\Components\FileUpload::make('trip_image')
                    ->disk('s3')
                    ->directory('trips')
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListTrips::route('/'),
            'create' => Pages\CreateTrip::route('/create'),
            'edit' => Pages\EditTrip::route('/{record}/edit'),
        ];
    }
}
