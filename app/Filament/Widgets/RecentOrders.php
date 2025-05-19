<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentOrders extends BaseWidget
{
    public function getHeading(): string
    {
        return 'Les 5 dernières commandes';
    }
    public function table(Table $table): Table
    {
        // $orders = [];
        return $table
            ->query( 
                Filament::getCurrentPanel()?->getId() == "admin" ? 
                Order::latest()->limit(5) :
                Order::where('user_id', auth()->id())
                     ->whereDate('created_at', Carbon::today()->toDateString())
                     ->where('status', 'En cours')
                     ->latest()->limit(5)

            )->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('nocmd') 
                    ->label('NoCMD')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('orderItems_count')
                    ->label('Nbre produits')
                    ->toggleable()
                    ->getStateUsing(function ($record) {
                        return $record->orderItems()->count();
                    })
                    ->default(0),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nom client')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                    Tables\Columns\TextColumn::make('address.quartier')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('lieu')
                    ->label('Lieu')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Lieu')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF'),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('Voir')
                        ->color('')
                        ->icon('heroicon-o-eye')
                        ->url(fn (Order $record) => route('filament.client.resources.client.orders.view', ['record' => $record->nocmd]))
                        ->openUrlInNewTab(false),
                    Tables\Actions\Action::make('edit')
                        ->label('Modifier')
                        ->icon('heroicon-o-pencil') // Utiliser l'icône de crayon // Afficher comme un bouton plutôt qu'un lien
                        ->color('') // Couleur du bouton
                        ->url(fn (Order $record) => route('filament.client.resources.client.orders.edit', ['record' => $record->nocmd])),
                    Tables\Actions\Action::make('masquer')
                    ->label('Supprimer')
                    ->icon('heroicon-o-trash')
                    ->action(fn (Order $record) => $record->update(['hidden_by_user' => true]))
                    ->requiresConfirmation()
                    ->color('danger')
                    ->after(function () {
                        Notification::make()
                            ->title('Commande supprimée !')
                            ->success()
                            ->send(); 
                    })
                ])->visible(fn () => Filament::getCurrentPanel()?->getId() == "client")
            ]);
    }

    public function getColumnSpan(): int | string
    {
        return 'full'; //  Prend toute la largeur
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }

    public function editOrder($recordId){
        $this->dispatch('openEditModal', orderId: $recordId);
    }
}
