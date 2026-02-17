<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\ProductResource\Pages;
use App\Filament\Resources\Admin\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

    protected static ?string $navigationLabel = 'Produits';

    protected static ?int $navigationSort = 5;

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
                    Forms\Components\Textarea::make('short_description')
                        ->label('Petite Description')
                        ->maxLength(255),
                    Forms\Components\Textarea::make('description')
                        ->label('Description')
                        ->maxLength(255)
                        ->required(),
                    Forms\Components\Select::make('sousCategory')
                        ->label('Sous catégorie')
                        ->relationship('sousCategory', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->native(false),
                    Forms\Components\TextInput::make('regular_price')
                        ->label('Prix')
                        ->required()
                        ->numeric()
                        ->minValue(0),
                    Forms\Components\TextInput::make('sale_price')
                        ->label('Prix promo')
                        ->numeric()
                        ->minValue(0)
                        ->lte('regular_price'),
                    Forms\Components\Select::make('stock_status')
                        ->label('Statut du stock')
                        ->options([
                            'instock' => 'Disponible',
                            'outofstock' => 'Indisponible',
                        ])
                        ->default('instock')
                        ->native(false)
                        ->required(),
                    Forms\Components\Select::make('featured')
                        ->label('En avant pour la publicité')
                        ->options([
                            '1' => 'Oui',
                            '0' => 'Non',
                        ])->default('0')
                        ->native(false)
                        ->required(),
                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public') 
                        ->directory('uploads/products') 
                        ->imageEditor()
                        ->required()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ]),
                    Forms\Components\FileUpload::make('images')
                        ->label('Gallerie d\'images')
                        ->image()
                        ->multiple()
                        ->disk('public') 
                        ->directory('uploads/products') 
                        ->imageEditor()
                        ->imageEditorAspectRatios([
                            '16:9',
                            '4:3',
                            '1:1',
                        ])
                        ->columnSpanFull(),
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->toggleable()
                    ->extra Attributes(fn (Product $record): array => [
                        'alt' => "{$record->slug} image",
                    ]),
                Tables\Columns\TextColumn::make('name') 
                    ->label('Nom')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description') 
                    ->label('Description')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('sousCategory.name')
                    ->label('Sous catégorie')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('final_price')
                    ->label('Prix')
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_status') 
                    ->label('Status')
                    ->toggleable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'instock' => 'success',
                        'outofstock' => 'danger',
                    })
                    ->formatStateUsing(function ($state) {
                        $options = [
                            'instock' => 'Disponible',
                            'outofstock' => 'Indisponible',
                        ];
                        
                        return $options[$state] ?? $state;
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('platDuJour')
                    ->label('Disponibilité')
                    ->options([
                        '0' => 'Disponible',
                        '1' => 'Pas disponible',
                    ]),
                Tables\Filters\SelectFilter::make('sousCategory')
                    ->label('Sous catégorie')
                    ->relationship('sousCategory', 'name')
                    ->searchable()
                    ->preload(),
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
            )
            ->defaultSort('created_at', 'desc');
    }

    //   CORRECTION: Eager loading de la sous-catégorie
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with(['sousCategory']);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
