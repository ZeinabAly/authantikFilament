<?php

namespace App\Filament\Resources\Admin\CategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Tables\Actions\ActionGroup;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SousCategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'sous_categories';


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->maxLength(255),
                Forms\Components\Select::make('category')
                    ->relationship('category', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->native(false),
                Forms\Components\FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->disk('public') 
                    ->directory('uploads/sousCategories') 
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        '16:9',
                        '4:3',
                        '1:1',
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->recordTitleAttribute('sousCategory.name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')->limit(30)
                    ->label('Description')
                    ->toggleable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Nbre produits')
                    ->default(0)
                    ->counts('products')
                     ->sortable(),
                
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->label('Nom'),
                Tables\Filters\Filter::make('description')
                    ->label('Description')
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // Eager loading du count de produits
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withCount('products');
    }
}
