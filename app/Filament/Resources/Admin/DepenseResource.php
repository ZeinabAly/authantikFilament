<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\DepenseResource\Pages;
use App\Filament\Resources\Admin\DepenseResource\RelationManagers;
use App\Models\Depense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DepenseResource extends Resource
{
    protected static bool $shouldSkipAuthorization = false;

    protected static ?string $model = Depense::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Dépenses';

    protected static ?int $navigationSort = 9;

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
                    Forms\Components\TextInput::make('description')
                        ->label('Description')
                        ->required(),
                    Forms\Components\TextInput::make('quantite')
                        ->label('Quantité')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('montant')
                        ->label('Montant')
                        ->numeric()
                        ->required(),
                    Forms\Components\DatePicker::make('date')
                        ->label('Date')
                        ->required(),
                    Forms\Components\FileUpload::make('justificatif')
                        ->label('Image de la Facture d\'achat')
                        ->image()
                        ->disk('public') 
                        ->directory('uploads/facturesAchats') 
                        ->imageEditor()
                        ->required()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('justificatif') 
                    ->label('Justificatif')
                    ->square(),
                Tables\Columns\TextColumn::make('description') 
                    ->label('Description')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantite') 
                    ->label('Quantité')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('montant') 
                    ->label('Montant')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF'),
                Tables\Columns\TextColumn::make('date') 
                    ->label('Date')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->dateTime('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->visible(fn ($record) => auth()->user()->hasAnyRole(['Admin', 'Manager'])),
                    Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListDepenses::route('/'),
            'create' => Pages\CreateDepense::route('/create'),
            'view' => Pages\ViewDepense::route('/{record}'),
            'edit' => Pages\EditDepense::route('/{record}/edit'),
        ];
    }
}
