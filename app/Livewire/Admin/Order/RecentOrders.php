<?php

namespace App\Livewire\Admin\Order;

use Carbon\Carbon;
use Filament\Tables;
use App\Models\Order;
use Livewire\Component;
use Filament\Tables\Table;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms;
use App\Filament\Resources\Admin\OrderResource\Pages;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use Livewire\Attributes\On;

#[On('commandeModifiée')]
class RecentOrders extends Component implements HasForms,HasTable
{

    use InteractsWithTable, InteractsWithForms;

    public static function getHeader(): string
    {
        return 'Liste des Catégories';
    }

    public function table(Table $table): Table
    {
        $today = Carbon::today();

        return $table
            ->query(
                Order::whereDate('created_at', $today)
                    ->when(auth()->check() && !auth()->user()->hasAnyRole(['Admin', 'Manager', 'Caissier']), function ($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->latest()
            )
            ->heading('Commandes récentes')
            ->paginated(false)
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
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Téléphone')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address.quartier')
                    ->toggleable()
                    ->counts('orderItems'),
                Tables\Columns\TextColumn::make('lieu')
                    ->label('Lieu')
                    ->toggleable()
                    ->toggleable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('table')
                    ->label('Table')
                    ->toggleable()
                    ->searchable()
                    ->sortable()
                    ->default('-'),
                Tables\Columns\TextColumn::make('total')
                    ->label('Total')
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->numeric(decimalPlaces: 0)
                    ->money('GNF'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('view')
                        ->label('Voir')
                        ->color('')
                        ->icon('heroicon-o-eye')
                        ->url(fn (Order $record) => route('filament.admin.resources.admin.orders.view', ['record' => $record->nocmd]))
                        ->openUrlInNewTab(false),
                    Tables\Actions\Action::make('edit')
                        ->label('Modifier')
                        ->icon('heroicon-o-pencil') // Utiliser l'icône de crayon // Afficher comme un bouton plutôt qu'un lien
                        ->color('') // Couleur du bouton
                        ->action(function (Order $record) {
                            $this->editOrder($record->id);

                    }),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function editOrder($recordId){
        $this->dispatch('openEditModal', orderId: $recordId);
    }

    public static function getPages(): array
    {
        return [
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }


    public function render()
    {
        return view('livewire.admin.order.recent-orders');
    }
}
