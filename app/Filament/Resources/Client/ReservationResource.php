<?php

namespace App\Filament\Resources\Client;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Reservation;
use Filament\Resources\Resource;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Client\ReservationResource\Pages;
use App\Filament\Resources\Client\ReservationResource\RelationManagers;

class ReservationResource extends Resource
{
    protected static ?string $model = Reservation::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';

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
                Forms\Components\TextInput::make('name')
                    ->label('Nom')
                    ->required(),
                Forms\Components\TextInput::make('phone')
                    ->label('Téléphone')
                    ->numeric()
                    ->Length(9)
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email(),
                Forms\Components\TextInput::make('nbrPers')
                    ->label('Nombre de personnes')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->label('Date')
                    ->required(),
                Forms\Components\TimePicker::make('heure')
                    ->label('Heure')
                    ->required(),
                Forms\Components\Textarea::make('details')
                    ->label('Note'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Reservation::query()
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
                Tables\Columns\TextColumn::make('email') 
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('heure') 
                    ->label('Heure')
                    ->searchable()
                    ->toggleable()
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nbrPers') 
                    ->label('Nbre personnes')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('details') 
                    ->label('Note')
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\Action::make('masquer')
                    ->label('Delete')
                    ->icon('heroicon-o-trash')
                    ->action(fn (Reservation $record) => $record->update(['hidden_by_user' => true]))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->after(function () {
                        Notification::make()
                            ->title('Reservation supprimée !')
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
            'index' => Pages\ListReservations::route('/'),
            'create' => Pages\CreateReservation::route('/create'),
            'edit' => Pages\EditReservation::route('/{record}/edit'),
        ];
    }
}
