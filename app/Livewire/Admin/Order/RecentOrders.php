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
#[On('notifUpdated')]
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
                    ->when(auth()->check() && !auth()->user()->hasAnyRole(['Admin', 'Manager']), function ($query) {
                        $query->where('user_id', auth()->id());
                    })
                    ->where('status', 'En cours')
                    ->latest()
            )
            ->heading('Commandes récentes')
            ->description('Les commandes annulées ou validées ne sont pas modifiables')
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
                    ->default('-'),
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
                        ->visible(fn ($record) => is_null($record->cancelled_date) && is_null($record->delivred_date))
                        ->icon('heroicon-o-pencil') 
                        ->color('')
                        ->url(fn (Order $record) => route('filament.admin.resources.admin.orders.edit', ['record' => $record->nocmd])),
                    Tables\Actions\Action::make('edit')
                        ->label('Telecharger le reçu')
                        ->icon('heroicon-o-arrow-down-tray') 
                        ->color('')
                        ->url(fn (Order $record) => route('facture.telecharger', ['order' => $record])),
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
