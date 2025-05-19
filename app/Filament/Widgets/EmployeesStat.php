<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use App\Models\Order;
use App\Models\Employee;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class EmployeesStat extends BaseWidget
{
    public function getNavigationLabel(): string
    {
        return 'Liste des employés en fonction de leurs activités';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Employee::query()
                ->withCount('pointages')
                ->withCount('absences')
                ->with('user')
                ->withCount('reservations')
            )
            ->columns([
                Tables\Columns\TextColumn::make('name') 
                    ->label('Nom')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('fonction') 
                    ->label('Fonction')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pointages_count') 
                    ->label('Presence')
                    ->default(0),
                Tables\Columns\TextColumn::make('absences_count') 
                    ->label('Absence')
                    ->default(0),
                Tables\Columns\TextColumn::make('orders_count')
                    ->label('Commandes')
                    ->state(function ($record) {
                        // Si c'est un caissier et qu'il a un user lié
                        if ($record->fonction === 'caissier' && $record->user_id) {
                            return Order::whereNotNull('employee_id')->where('user_id', $record->user_id)->count();
                        }
        
                        // Sinon (serveur par exemple)
                        return Order::whereNotNull('employee_id')->where('employee_id', $record->id)->count();
                    })
                    ->default(0),
                Tables\Columns\TextColumn::make('reservations_count') 
                    ->label('Réservations')
                    ->default(0),
            ]);
    }

    // public static function getEloquentQuery(): Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->withCount('pointages');
    // }

    public function getColumnSpan(): int | string
    {
        return 'full'; //  Prend toute la largeur
    }
}
