<?php

namespace App\Filament\Resources\Admin;

use Filament\Forms;
use Filament\Tables;
use App\Models\Slider;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Admin\SliderResource\Pages;
use App\Filament\Resources\Admin\SliderResource\RelationManagers;

class SliderResource extends Resource
{
    protected static ?string $model = Slider::class;

    protected static ?string $navigationIcon = 'heroicon-o-presentation-chart-line';

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
                    Forms\Components\TextInput::make('titre')
                        ->label('Titre')
                        ->live(onBlur: true, debounce:100)
                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('sous_titre')
                        ->label('Sous titre'),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug'),
                    Forms\Components\TextInput::make('texte')
                        ->label('Texte'),
                    Forms\Components\Select::make('page')
                        ->label('Page')
                        ->options([
                            'index' => 'Index',
                            'menu' => 'Menu',
                            'reservation' => 'Réservation',
                            'contact' => 'Contact',
                        ])
                        ->native(false),
                    Forms\Components\TextInput::make('textButton')
                        ->label('Texte du bouton'),
                    Forms\Components\Select::make('linkButton')
                        ->label('Le bouton redirige vers')
                        ->options([
                            'home.index' => 'Page Index',
                            'home.menu' => 'Page Menu',
                            'home.reservation.create' => 'Page Réservation',
                            'home.contact' => 'Page Contact',
                        ])
                        ->native(false),
                    Forms\Components\TextInput::make('position')
                        ->label('Position d\'affichage. Ex: Banniere'),
                    Forms\Components\FileUpload::make('image')
                        ->label('Image')
                        ->image()
                        ->disk('public') 
                        ->directory('uploads/sliders') 
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
            ->query(Slider::latest())
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->square()
                    ->toggleable()
                    ->url(fn ($record) => asset('storage/' . $record->image))
                    ->extraImgAttributes(fn (Slider $record): array => [
                        'alt' => "{$record->titre} image",
                    ]),
                Tables\Columns\TextColumn::make('titre') 
                    ->label('Titre')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('texte') 
                    ->label('Texte')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('page') 
                    ->label('Page')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position') 
                    ->label('Position')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('is_active') 
                    ->label('Visible')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state) {
                        $options = [
                            '1' => 'Oui',
                            '0' => 'Non',
                        ];
                        
                        return $options[$state] ?? $state;
                    }),
                
            ])
            ->filters([
                Tables\Filters\Filter::make('titre')
                    ->label('Titre'),
                Tables\Filters\Filter::make('texte')
                    ->label('Texte'),
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
            'index' => Pages\ListSliders::route('/'),
            'create' => Pages\CreateSlider::route('/create'),
            'view' => Pages\ViewSlider::route('/{record}'),
            'edit' => Pages\EditSlider::route('/{record}/edit'),
        ];
    }
}
