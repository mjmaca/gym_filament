<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeliveryReceiptResource\Pages;
use App\Filament\Resources\DeliveryReceiptResource\RelationManagers;
use App\Models\DeliveryReceipt;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DeliveryReceiptResource extends Resource
{
    protected static ?string $model = DeliveryReceipt::class;
    protected static ?int $navigationSort = 7;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('document_status')
                    ->options([
                        'no_issues' => 'No Issues',
                        'facing_issues' => 'Facing Issues',
                    ])
                    ->default('no_issues')
                    ->required(),
                Forms\Components\Select::make('approved_by')
                    ->options([
                        'checker' => 'Checker',
                        'billing' => 'Billing',
                        'payroll' => 'Payroll',
                        'operations' => 'Operations',
                        'manager' => 'Manager',
                        'hr' => 'HR',
                    ])
                    ->required(),
                Forms\Components\Datepicker::make('date')->required(),
                // Forms\Components\Select::make('delivery_to')->relationship('clients', 'name')->label('Delivery To'),
                Forms\Components\TextInput::make('delivery_receipt_no')->required(),
                Forms\Components\TextInput::make('address')->required(),
                Forms\Components\TextInput::make('trip_no')->required(),
                Forms\Components\TextInput::make('tin_no')->required(),
                Forms\Components\TextInput::make('custom_code')->required(),
                Forms\Components\TextInput::make('ref_so_no')->required(),
                Forms\Components\TextInput::make('hauler')->required(),
                Forms\Components\TextInput::make('ref_po_no')->required(),
                Forms\Components\TextInput::make('plate_no')->required(),
                Forms\Components\TextInput::make('warehouse_location')->required(),
                Forms\Components\TextInput::make('checked_by')->required(),
                Forms\Components\TextInput::make('trucking')->required(),
                Forms\Components\TextInput::make('total_amount')->numeric()->required(),

                Section::make('Item Details')
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

                Forms\Components\Repeater::make('item_details')->label('Item Details')->maxWidth('100%')
                    ->schema([
                        Forms\Components\TextInput::make('code')->required(),
                        Forms\Components\TextInput::make('description')->required(),
                        Forms\Components\TextInput::make('quantity')->numeric()->required(),
                        Forms\Components\TextInput::make('unit_price')->numeric()->required(),
                        Forms\Components\TextInput::make('amount')->numeric()->required(),
                    ])
                    ->required(),

                Section::make('Item Details')
                    ->schema([
                        Forms\Components\FileUpload::make('delivery_receipt_image')
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
            'index' => Pages\ListDeliveryReceipts::route('/'),
            'create' => Pages\CreateDeliveryReceipt::route('/create'),
            'edit' => Pages\EditDeliveryReceipt::route('/{record}/edit'),
        ];
    }
}
