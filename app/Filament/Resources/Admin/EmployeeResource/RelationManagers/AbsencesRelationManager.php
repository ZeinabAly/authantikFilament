<?php

namespace App\Filament\Resources\Admin\EmployeeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsencesRelationManager extends RelationManager
{
    protected static string $relationship = 'absences';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->options([
                        'congé' => 'Congé',
                        'maladie' => 'Maladie',
                        'absence injustifiée' => 'Absence non injustifiée',
                        'autre' => 'Autre',
                    ])->native(false)
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\Select::make('approved')
                    ->label('Approuvée ?')
                    ->options([
                        '0' => 'Non',
                        '1' => 'Oui',
                    ])
                    ->default('0')
                    ->native(false)
                    ->required(),
                Forms\Components\Textarea::make('raison')
                    ->label('Raisons'),
            ]);
    }

    // Pour ne pas avoir a choisir un employé
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     // Ajouter explicitement l'employee_id
    //     $data['employee_id'] = $this->getOwnerRecord()->id;
        
    //     return $data;
    // }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('type')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            'congé' => 'Congé',
                            'maladie' => 'Maladie',
                            'absence injustifiée' => 'Absence non injustifiée',
                            'autre' => 'Autre',
                        ];
                        return $options[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('approved')
                    ->label('Approuvée ? ')
                    ->toggleable()
                    ->formatStateUsing(function ($state){
                        $options = [
                            '0' => 'Non',
                            '1' => 'Oui',
                        ];
                        return $options[$state] ?? $state;
                    }),
                Tables\Columns\TextColumn::make('raison')
                    ->label('Raisons')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('type')
                    ->label('Type'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
}
