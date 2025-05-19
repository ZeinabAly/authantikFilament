<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\HoraireResource\Pages;
use App\Filament\Resources\Admin\HoraireResource\RelationManagers;
use App\Models\Horaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HoraireResource extends Resource
{
    protected static ?string $model = Horaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

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
                    Forms\Components\Select::make('name')
                        ->label('Nom')
                        ->options([
                            'Matinée' => 'Matinée',
                            'Soirée' => 'Soirée',
                        ])
                        ->default('Matinée')
                        ->native(false),
                    Forms\Components\TimePicker::make('start_time')
                        ->label('Heure de début'),
                    Forms\Components\TimePicker::make('end_time')
                        ->label('Heure de fin'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Horaire::latest())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_time')
                    ->label('Heure de début')
                    ->dateTime('H:i:s')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_time')
                    ->label('Heure de fin')
                    ->dateTime('H:i:s')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('start_time')
                    ->label('Début'),
                Tables\Filters\Filter::make('end_time')
                    ->label('Fin'),
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
                ]),
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
            'index' => Pages\ListHoraires::route('/'),
            'create' => Pages\CreateHoraire::route('/create'),
            'edit' => Pages\EditHoraire::route('/{record}/edit'),
        ];
    }
}
