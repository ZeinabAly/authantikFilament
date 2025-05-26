<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\RestaurantTableResource\Pages;
use App\Filament\Resources\Admin\RestaurantTableResource\RelationManagers;
use App\Models\RestaurantTable;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RestaurantTableResource extends Resource
{
    protected static ?string $model = RestaurantTable::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 13;

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
                    Forms\Components\TextInput::make('name')
                        ->label('Nom')
                        ->required(),
                    Forms\Components\Select::make('position')
                        ->label('Position')
                        ->options([
                            'salle1' => 'Salle 1',
                            'salle_vip' => 'Salle VIP',
                        ])
                        ->placeholder('-- Sélectionnez une option --')
                        ->required(),
                    Forms\Components\Select::make('seats')
                        ->label('Nombre de place')
                        ->options([
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                        ])
                        ->required()
                        ->placeholder('-- Sélectionnez une option --'),
                    Forms\Components\Select::make('status')
                        ->label('Statut')
                        ->options([
                            'free' => 'Libre',
                            'occupied' => 'Occupée',
                            'reserved' => 'Reservée',
                        ])
                        ->placeholder('-- Sélectionnez une option --')
                        ->required(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name') 
                    ->label('Nom')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position') 
                    ->label('Position')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            'salle1' => 'Salle 1',
                            'salle_vip' => 'Salle VIP',
                        ];
                        return $options[$state] ?? $state ;
                    }),
                Tables\Columns\TextColumn::make('seats') 
                    ->label('Nombre de place')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            '1' => '1',
                            '2' => '2',
                            '3' => '3',
                            '4' => '4',
                            '5' => '5',
                        ];
                        return $options[$state] ?? $state ;
                    }),
                Tables\Columns\TextColumn::make('status') 
                    ->label('Status')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            'free' => 'Libre',
                            'occupied' => 'Occupée',
                            'reserved' => 'Reservée',
                        ];
                        return $options[$state] ?? $state ;
                    })->default('free'),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('position')
                    ->label('Position'),
                Tables\Filters\Filter::make('seats')
                    ->label('Seats'),
                Tables\Filters\Filter::make('status')
                    ->label('Statut'),
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
            'index' => Pages\ListRestaurantTables::route('/'),
            'create' => Pages\CreateRestaurantTable::route('/create'),
            'view' => Pages\ViewRestaurantTable::route('/{record}'),
            'edit' => Pages\EditRestaurantTable::route('/{record}/edit'),
        ];
    }
    
}
