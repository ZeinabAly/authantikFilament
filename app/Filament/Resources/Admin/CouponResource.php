<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\CouponResource\Pages;
use App\Filament\Resources\Admin\CouponResource\RelationManagers;
use App\Models\Coupon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CouponResource extends Resource
{
    protected static ?string $model = Coupon::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('')
                ->schema([
                    Forms\Components\TextInput::make('value')
                        ->label('Valeur de coupon')
                        ->numeric()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('cart_value')
                        ->label('Achat minimum pour appliquer')
                        ->numeric()
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('type')
                        ->label('Type ')
                        ->options([
                            'fixed' => 'Valeur',
                            'percent' => 'Pourcentage',
                        ])
                        ->native(false),
                    Forms\Components\DatePicker::make('expiry_date')
                        ->label('Date d\'expiration')
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Coupon::latest())
            ->columns([
                Tables\Columns\TextColumn::make('code') 
                    ->label('Code')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('value') 
                    ->label('Valeur')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cart_value') 
                    ->label('Valeur minimale')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('expiry_date') 
                    ->label('Date d\'expiration')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('code')
                    ->label('Code'),
                Tables\Filters\Filter::make('value')
                    ->label('Value'),
                Tables\Filters\Filter::make('cart_value')
                    ->label('Valeur minimale'),
                Tables\Filters\Filter::make('expiry_date')
                    ->label('Date d\'expiration'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                    Tables\Actions\RestoreAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                ])
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
            'index' => Pages\ListCoupons::route('/'),
            'create' => Pages\CreateCoupon::route('/create'),
            'edit' => Pages\EditCoupon::route('/{record}/edit'),
        ];
    }
}
