<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\UserResource\Pages;
use App\Filament\Resources\Admin\UserResource\RelationManagers;

class UserResource extends Resource 
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

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
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->label('Téléphone')
                        ->required()
                        ->tel()
                        ->numeric()
                        ->Length(9),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('password')
                        ->label('Mot de passe')
                        ->required()
                        ->password()
                        ->maxLength(255)
                        ->revealable()
                        ->visible(fn () => auth()->user()->id === User::find(request()->route('record'))?->id)
                        ->dehydrated(fn ($state) => filled($state)), // N'inclut ce champ dans les données à sauvegarder que si sa valeur n'est pas vide
                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public') 
                        ->directory('uploads/users') 
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                    Forms\Components\Select::make('roles')
                        ->label('Rôle')
                        ->relationship('roles', 'name')
                        ->preload()
                        ->searchable(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                auth()->user()->hasRole('Admin')
                ? User::where('is_active', true)->latest()
                : User::whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Admin');
                })->latest()
            )
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->toggleable()
                    ->url(fn ($record) => asset('storage/' . $record->image))
                    ->extraImgAttributes(fn (User $record): array => [
                        'alt' => "{$record->titre} image",
                    ]),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->sortable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->date('Y-m-d'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                
            ])
            ->filters([
                Filter::make('name')
                    ->label('Nom'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->visible(fn ($record) => auth()->user()->hasRole('Admin') || auth()->user()->id === $record->id),
                    Tables\Actions\ViewAction::make(),
                    // Tables\Actions\DeleteAction::make()
                    //     ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin'])),
                        // ->visible(fn ($record) => auth()->user()->hasRole('Admin') || auth()->user()->id === $record->id),y
                    Tables\Actions\Action::make('delete')
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager']))
                        ->label('Supprimer')
                        ->icon('heroicon-o-trash') 
                        ->requiresConfirmation()
                        ->color('danger')
                        ->action(function (User $record) {
                            $record->update([
                                'is_active' => 0
                            ]);
                        })
                        ->after(function () {
                            Notification::make()
                                    ->title('Utilisateur supprimé !')
                                    ->success()
                                    ->send();
                        })   
                    ,
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
