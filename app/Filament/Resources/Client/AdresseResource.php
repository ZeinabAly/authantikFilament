<?php

namespace App\Filament\Resources\Client;

use Filament\Forms;
use Filament\Tables;
use App\Models\Address;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Client\AdresseResource\Pages;
use App\Filament\Resources\Client\AdresseResource\RelationManagers;

class AdresseResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    public static function getNavigationBadge(): ?string
    {
        if(auth()->check()){
            return static::getModel()::where('user_id', auth()->user()->id)->count();
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Address::query()
                ->where('user_id', auth()->user()->id)
                ->where('hidden_by_user', 0)
                ->latest()
            )
            ->columns([
                Tables\Columns\TextColumn::make('name') 
                    ->label('Nom')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone') 
                    ->label('Téléphone')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commune') 
                    ->label('Commune')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quartier') 
                    ->label('Quartier')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address') 
                    ->label('Adresse (Nom de la concession)')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('point_de_reference') 
                    ->label('Point de reference')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('commune')
                    ->label('Commune'),
                Tables\Filters\Filter::make('quartier')
                    ->label('Quartier'),
                Tables\Filters\Filter::make('address')
                    ->label('Adresse'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('masquer')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->action(fn (Address $record) => $record->update(['hidden_by_user' => true]))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->after(function () {
                        Notification::make()
                            ->title('Adresse supprimée !')
                            ->success()
                            ->send(); 
                    })
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
            'index' => Pages\ListAdresses::route('/'),
            'create' => Pages\CreateAdresse::route('/create'),
            'edit' => Pages\EditAdresse::route('/{record}/edit'),
        ];
    }
}
