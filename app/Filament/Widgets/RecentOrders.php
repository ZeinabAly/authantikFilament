<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentOrders extends BaseWidget
{
    // Rafraîchir toutes les 30 secondes pour les commandes en temps réel
    protected static ?string $pollingInterval = '30s';

    public function getHeading(): string
    {
        return 'Les 5 dernières commandes';
    }
    
    public function table(Table $table): Table
    {
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
                Tables\Columns\TextColumn::make('order_items_count')
                    ->label('Nbre produits')
                    ->toggleable()
                    ->counts('orderItems')
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
                    ->default('N/A'),
                Tables\Columns\TextColumn::make('lieu')
                    ->label('Lieu')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'En cours' => 'warning',
                        'Livrée' => 'success',
                        'Annulée' => 'danger',
                        default => 'gray',
                    }),
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
                        ->color('warning') // Couleur du bouton
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

    // CORRECTION: Méthode séparée pour la requête avec eager loading
    protected function getTableQuery(): Builder
    {
        $panelId = Filament::getCurrentPanel()?->getId();
        
        $query = Order::query()
            ->with(['address'])  // Eager loading de l'adresse
            ->withCount('orderItems')  // Eager loading du count
            ->latest()
            ->limit(5);
        
        if ($panelId !== "admin") {
            $query->where('user_id', auth()->id())
                ->whereDate('created_at', Carbon::today())
                ->where('status', 'En cours');
        }
        
        return $query;
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
