<?php

namespace App\Filament\Resources\Admin\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CalendrierEmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'calendrier_employees';

    protected static ?string $modelLabel = 'work day';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('jour')
                    ->label('Jour')
                    ->options([
                        'lundi' => 'Lundi',
                        'mardi' => 'Mardi',
                        'mercredi' => 'Mercredi',
                        'jeudi' => 'Jeudi',
                        'vendredi' => 'Vendredi',
                        'samedi' => 'Samedi',
                        'dimanche' => 'Dimanche',
                    ])->native(false)
                    ->required(),
                Forms\Components\Select::make('horaire_id')
                    ->label('Horaire')
                    ->relationship('horaire', 'name')
                    ->required()
                    ->native(false),
            ]);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ajouter explicitement l'employee_id
        $data['employee_id'] = $this->getOwnerRecord()->id;
        
        return $data;
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('employee.name')
            ->columns([
                Tables\Columns\TextColumn::make('jour')
                    ->label('Jour')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('horaire.name')
                    ->label('Horaire')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('jour')
                    ->label('Jour'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
