<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceInvoiceResource\Pages;
use App\Filament\Resources\ServiceInvoiceResource\RelationManagers;
use App\Models\ServiceInvoice;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceInvoiceResource extends Resource
{
    protected static ?string $model = ServiceInvoice::class;
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date_submit')->required(),
                Forms\Components\TextInput::make('service_invoice_no')->required(),
                Forms\Components\TextInput::make('trip_no')->required(),
                Forms\Components\TextInput::make('client_name')->required(),
                Forms\Components\TextInput::make('terms')->required(),
                Forms\Components\TextInput::make('approved_by')->required(),
                Forms\Components\TextInput::make('total_amount')->default(0)->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date_submit')->label('Date Submitted'),
                Tables\Columns\TextColumn::make('service_invoice_no')->label('Service Invoice No'),
                Tables\Columns\TextColumn::make('trip_no')->label('Trip No'),
                Tables\Columns\TextColumn::make('client_name')->label('Client Name'),
                Tables\Columns\TextColumn::make('terms')->label('Terms'),
                Tables\Columns\TextColumn::make('approved_by')->label('Approved By'),
                Tables\Columns\TextColumn::make('total_amount')->label('Total Amount'),
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
            'index' => Pages\ListServiceInvoices::route('/'),
            'create' => Pages\CreateServiceInvoice::route('/create'),
            'edit' => Pages\EditServiceInvoice::route('/{record}/edit'),
        ];
    }
}
