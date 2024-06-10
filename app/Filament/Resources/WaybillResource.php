<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WaybillResource\Pages;
use App\Filament\Resources\WaybillResource\RelationManagers;
use App\Models\Waybill;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WaybillResource extends Resource
{
    protected static ?string $model = Waybill::class;
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('waybill_no')->required(),
                Forms\Components\Datepicker::make('date')->required(),
                Forms\Components\TextInput::make('shipment_no')->label('Shipment No. / DR No.')->required(),
                Forms\Components\TextInput::make('trip_ticket_no')->required(),
                Forms\Components\TextInput::make('document_status')->required(),
                Forms\Components\TextInput::make('approved_by')->required(),

                Section::make('Trip Information')
                    ->description('This fields are the trip informations')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('plate_no')->required(),
                        Forms\Components\Select::make('truck_type')->options([
                            '10W' => '10W',
                            '40FT' => '40FT',
                        ])->default('10W')->required(),
                        Forms\Components\TextInput::make('type_of_trip')->required(),
                        Forms\Components\TextInput::make('routes')->required(),
                        Forms\Components\TextInput::make('driver_name')->required(),
                        Forms\Components\TextInput::make('helper_name')->required(),
                    ]),


                Section::make('Document Clipboard 1')
                    ->description('This fields are for loading information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('origin_location')->required(),
                        Forms\Components\DateTimePicker::make('truck_in_origin')->required(),
                        Forms\Components\DateTimePicker::make('received_datetime')->required(),
                    ]),

                Section::make('Loading')
                    ->description('This fields are for loading information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DateTimePicker::make('loading_time_start')->required(),
                        Forms\Components\DateTimePicker::make('loading_time_finish')->required(),
                        Forms\Components\DateTimePicker::make('loading_docs_release')->required(),
                        Forms\Components\DateTimePicker::make('loading_truck_out')->required(),
                    ]),

                Section::make('Document Clipboard 2')
                    ->description('This fields are for unloading information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('destination_location')->required(),
                        Forms\Components\Datepicker::make('truck_in_destination')->required(),
                        Forms\Components\Datepicker::make('received_datetime_destination')->required(),
                    ]),
                
                Section::make('Unloading')
                    ->description('This fields are for unloading information')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Datepicker::make('unloading_time_start')->required(),
                        Forms\Components\Datepicker::make('unloading_time_finish')->required(),
                        Forms\Components\Datepicker::make('unloading_docs_release')->required(),
                        Forms\Components\Datepicker::make('unloading_truck_out')->required(),
                    ]),
                
                Section::make('Attachments')
                    ->schema([
                        Forms\Components\FileUpload::make('waybill_image')
                            ->disk('s3')
                            ->directory('pangga-trucking')
                            ->visibility('public'),
                    ]),
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
            'index' => Pages\ListWaybills::route('/'),
            'create' => Pages\CreateWaybill::route('/create'),
            'edit' => Pages\EditWaybill::route('/{record}/edit'),
        ];
    }
}
