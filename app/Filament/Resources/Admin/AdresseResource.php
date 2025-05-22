<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\AdresseResource\Pages;
use App\Filament\Resources\Admin\AdresseResource\RelationManagers;
use App\Models\Address;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdresseResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

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
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Address::latest())
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
                    ->label('Adresse (Nom de votre concession)')
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
                Tables\Filters\TrashedFilter::make(),
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
            ])
            ->recordUrl(
                fn ($record) => static::getUrl('view', ['record' => $record])
            );
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
            'view' => Pages\ViewAdresse::route('/{record}'),
            'edit' => Pages\EditAdresse::route('/{record}/edit'),
        ];
    }
}
