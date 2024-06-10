<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PalletIssuanceResource\Pages;
use App\Filament\Resources\PalletIssuanceResource\RelationManagers;
use App\Models\PalletIssuance;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PalletIssuanceResource extends Resource
{
    protected static ?string $model = PalletIssuance::class;
    protected static ?int $navigationSort = 6;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('pallet_issuance_no')->required(),
                Forms\Components\Datepicker::make('date')->required(),

                Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('reference_no')->required(),
                        Forms\Components\TextInput::make('warehouse_location')->required(),
                        Forms\Components\Select::make('document_status')->options([
                            'pending' => 'Pending',
                            'approved' => 'Approved',
                            'rejected' => 'Rejected',
                        ])->default('pending')->required(),
                        Forms\Components\TextInput::make('approved_by')->required()
                    ])
                    ->columns(3),

                Section::make('Trip and Driver')
                    ->schema([
                        Forms\Components\TextInput::make('trip_no')->required(),
                        Forms\Components\TextInput::make('driver')->required(),
                        Forms\Components\TextInput::make('plate_no')->required(),
                        Forms\Components\TextInput::make('trucker')->required(),
                    ])
                    ->columns(3),

                Section::make('Attachments')
                    ->schema([
                        Forms\Components\FileUpload::make('pallet_issuance_image')
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
            'index' => Pages\ListPalletIssuances::route('/'),
            'create' => Pages\CreatePalletIssuance::route('/create'),
            'edit' => Pages\EditPalletIssuance::route('/{record}/edit'),
        ];
    }
}
