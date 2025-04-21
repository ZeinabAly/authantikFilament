<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\OrderResource\Pages;
use App\Filament\Resources\Admin\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id())
                    ->dehydrated(true),
                Forms\Components\TextInput::make('nom')
                    ->label('Nom')
                    ->required()
                    ->maxLength(255)->live(),
                Forms\Components\TextInput::make('phone')
                    ->label('Téléphone')
                    ->required()
                    ->numeric()
                    ->length(9),
                Forms\Components\Select::make('lieu')
                    ->label('Lieu')
                    ->required()
                    ->options([
                        'Sur place' => 'Sur place',
                        'A emporter' => 'A emporter',
                        'A livrer' => 'A livrer'
                    ]) 
                    ->placeholder('Selectionnez une option')
                    ->native(false)
                    ->live(),
                Forms\Components\Select::make('adresse_id')
                    ->label('Choisissez ou créez une adresse')
                    ->relationship('address', 'name')
                    ->searchable()
                    ->preload()
                    ->native(false)
                    ->placeholder('Selectionnez une option')
                    ->hidden(fn (callable $get): bool => $get('lieu') !== 'A livrer')
                    ->createOptionForm(
                        [
                            Forms\Components\Hidden::make('user_id')
                                ->default(auth()->id())
                                ->dehydrated(true), // S'assure que la valeur est bien sauvegardée,
                            Forms\Components\TextInput::make('name')
                                ->label('Nom')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('phone')
                                ->label('Téléphone')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('commune')
                                ->label('Commune')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('quartier')
                                ->label('Quartier')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('address')
                                ->label('Adresse')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\TextInput::make('point_de_reference')
                                ->label('Point de reference')
                                ->required()
                                ->maxLength(255),
                            Forms\Components\Select::make('isdefault')
                                ->label('Définir comme adresse par défaut ? ')
                                ->options([
                                    '1' => 'Oui',
                                    '0' => 'Non',
                                ])
                            ->native(false),
                        ]
                    )
                    ->createOptionAction(function ($action) {
                        return $action
                            ->modalHeading('Créer une adresse');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nocmd') 
                    ->label('NoCMD')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItems_count')
                    ->label('Nbre produits')
                    ->toggleable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom client')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address.quartier')
                    ->toggleable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('lieu')
                    ->label('Lieu')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Lieu')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            'create' => Pages\CreateOrderModal::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
