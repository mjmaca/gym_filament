<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MembershipPlanResource\Pages;
use App\Filament\Resources\MembershipPlanResource\RelationManagers;
use App\Models\MembershipPlan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MembershipPlanResource extends Resource
{
    protected static ?string $model = MembershipPlan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->required()
                    ->label('Type')
                    ->placeholder('Select the plan type')
                    ->options([
                        'gold' => 'Gold Membership',
                        'silver' => 'Silver Membership',
                        'vip_siler' => 'VIP Silver Membership',
                        'vip_white' => 'VIP White Membership',
                        'vip_black' => 'VIP Black Membership',
                    ]),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->label('Price')
                    ->prefix('PHP'),
                Forms\Components\TextInput::make('duration')
                    ->required()
                    ->label('Duration')
                    ->numeric()
                    ->suffix('months')
                    ->placeholder('Enter the duration in months'),
                Forms\Components\Select::make('access_discount')
                    ->label('Access Discount')
                    ->placeholder('Select access discount')
                    ->options([
                        '30' => '30%',
                        '50' => '50%',
                        '100' => '100%',
                    ]),
                Forms\Components\Select::make('extension_discount')
                    ->label('Extension Discount')
                    ->placeholder('Select extension discount')
                    ->options([
                        '0' => 'No extension',
                        '1' => '1 Month Extension',
                        '2' => '2 Month Extension',
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Description')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->prefix('PHP ')
                    ->formatStateUsing(fn($record): string => number_format($record->price, 2, '.', ','))
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('duration')
                    ->label('Duration (months)')
                    ->suffix(' Months')
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
            'index' => Pages\ListMembershipPlans::route('/'),
            'create' => Pages\CreateMembershipPlan::route('/create'),
            'edit' => Pages\EditMembershipPlan::route('/{record}/edit'),
        ];
    }
}
