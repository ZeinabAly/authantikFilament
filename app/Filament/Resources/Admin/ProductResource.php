<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\ProductResource\Pages;
use App\Filament\Resources\Admin\ProductResource\RelationManagers;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-plus';

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
                        ->numeric(),
                    Forms\Components\TextInput::make('sale_price')
                        ->label('Prix promo')
                        ->numeric(),
                    Forms\Components\Select::make('stock_status')
                        ->options([
                            'instock' => 'Disponible',
                            'outofstock' => 'Indisponible',
                        ])
                        ->default('instock')
                        ->native(false),
                    Forms\Components\Select::make('featured')
                        ->label('En avant pour la publicité')
                        ->options([
                            '1' => 'Oui',
                            '0' => 'Non',
                        ])->default('0')
                        ->native(false),
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
            ->query(Product::latest())
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->toggleable()
                    ->url(fn ($record) => asset('storage/' . $record->image))
                    ->extraImgAttributes(fn (Product $record): array => [
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
                Tables\Columns\TextColumn::make('regular_price')
                    ->label('Prix')
                    ->formatStateUsing(function ($state, $record) {
                        return $record->sale_price ?? $record->regular_price;
                    })
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF'),
                Tables\Columns\TextColumn::make('stock_status') 
                    ->label('Status')
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $options = [
                            'instock' => 'Disponible',
                            'outofstock' => 'Indisponible',
                        ];
                        
                        return $options[$state] ?? $state;
                    }),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('description')
                    ->label('Description'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
