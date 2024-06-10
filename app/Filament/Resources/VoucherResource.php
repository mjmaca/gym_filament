<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Information')
                    ->description('This fields are the basic requirements')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('id')->default(fn() => (string) \Illuminate\Support\Str::uuid())->hidden(),
                        Forms\Components\TextInput::make('voucher_no')->required(),
                        Forms\Components\TextInput::make('trip_no')->required(),
                        Forms\Components\TextInput::make('plate_no')->required(),
                        Forms\Components\TextInput::make('destination')->required(),
                    ]),

                Section::make('Amount Information')
                    ->description('Enter first and second amount details')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('first_amount')->default(0)->required(),
                        Forms\Components\TextInput::make('first_received_by')->required(),
                        Forms\Components\TextInput::make('second_amount')->default(0),
                        Forms\Components\TextInput::make('second_received_by'),
                    ]),

                Section::make('Status & Approval Information')
                    ->description('Enter approval and status details')
                    ->columns(1)
                    ->schema([
                        Forms\Components\Select::make('approved_by')->options([
                            'Checker' => 'Checker',
                            'Billing' => 'Billing',
                            'Encoder' => 'Encoder',
                            'Manager' => 'Manager',
                        ]),
                        Forms\Components\TextInput::make('status')->required(),
                        Forms\Components\Checkbox::make('is_archive')->default(false),
                        Forms\Components\Checkbox::make('is_liquidated')->default(false),
                    ]),

                Section::make('Attachments')
                    ->schema([
                        Forms\Components\FileUpload::make('voucher_image')
                            ->disk('s3')
                            ->directory('pangga-trucking')
                            ->visibility('public'),
                        Forms\Components\FileUpload::make('attached_liquidation')
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
                Tables\Columns\TextColumn::make('voucher_no')->label('Voucher No'),
                Tables\Columns\TextColumn::make('trip_no')->label('Trip No'),
                Tables\Columns\TextColumn::make('plate_no')->label('Plate No'),
                Tables\Columns\TextColumn::make('destination')->label('Destination'),
                Tables\Columns\TextColumn::make('first_amount')->label('First Amount'),
                Tables\Columns\TextColumn::make('first_received_by')->label('First Received By'),
                Tables\Columns\TextColumn::make('second_amount')->label('Second Amount'),
                Tables\Columns\TextColumn::make('second_received_by')->label('Second Received By'),
                Tables\Columns\TextColumn::make('approved_by')->label('Approved By'),
                Tables\Columns\TextColumn::make('status')->label('Status'),
                Tables\Columns\IconColumn::make('is_liquidated')
                    ->label('Is Liquidated')
                    ->icon(fn (string $state): string => match ($state) {
                    '1' => 'heroicon-s-check-circle',
                    '0' => 'heroicon-s-x-circle',
                }),
                Tables\Columns\TextColumn::make('attached_liquidation')->label('Attached Liquidation'),
                Tables\Columns\ImageColumn::make('voucher_image')->label('Voucher Image')->disk('s3')->square(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
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
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
