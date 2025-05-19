
<div>
    <!-- DETAILS DE LA COMMANDE -->
    <div class="table-wrapper">
        <h2>Détails de la commande</h2>
        <div class="fi-ta">
            <div class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="searchZone"></div>
                <div class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
                    <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                        <thead class="divide-y divide-gray-200 dark:divide-white/5">
                            <tr class="bg-gray-50 dark:bg-white/5">
                                <th>Nocmd</th>
                                <th>Nbre produits</th>
                                <th>Nom client</th>
                                <th>Téléphone</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Lieu</th>
                                <th>Total</th>
                                <th>Date</th>
                            </tr>  
                        </thead>
    
                        <tbody class="fi-ta-tbody divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                            <tr>
                                <td>{{$order->nocmd}}</td>
                                <td>{{$order->orderItems->count()}}</td>
                                <td>{{$order->name}}</td>
                                <td>{{$order->phone}}</td>
                                <td>{{$order->address->quartier ?? "-"}}</td>
                                <td>{{$order->status}}</td>
                                <td>{{$order->lieu}}</td>
                                <td>{{number_format($order->total, 0,'.', '.')}} GNF</td>
                                <td>{{$order->created_at->format('d-m-Y')}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- PRODUITS COMMANDES -->
    <div class="table-wrapper">
        <h2>Produits commandés</h2>
        <div class="fi-ta">
            <div class="fi-ta-ctn divide-y divide-gray-200 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:divide-white/10 dark:bg-gray-900 dark:ring-white/10">
                <div class="searchZone"></div>
                <div class="fi-ta-content relative divide-y divide-gray-200 overflow-x-auto dark:divide-white/10 dark:border-t-white/10">
                    <table class="fi-ta-table w-full table-auto divide-y divide-gray-200 text-start dark:divide-white/5">
                        <thead class="divide-y divide-gray-200 dark:divide-white/5">
                            <tr class="bg-gray-50 dark:bg-white/5">
                                <th>Nom</th>
                                <th>Catégorie</th>
                                <th>Prix unitaire</th>
                                <th>Quantité</th>
                                <th>Total</th>
                            </tr>  
                        </thead>
    
                        <tbody class="fi-ta-tbody divide-y divide-gray-200 whitespace-nowrap dark:divide-white/5">
                            @foreach($orderItems as $orderItem)
                            <tr>
                                <td>{{$orderItem->product->name}}</td>
                                <td>{{$orderItem->product->sousCategory->name}}</td>
                                <td>{{number_format($orderItem->price, 0,'.', '.')}} GNF</td>
                                <td>{{$orderItem->quantity}}</td>
                                <td>{{number_format($orderItem->price * $orderItem->quantity, 0,'.', '.')}} GNF</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ADRESSE DE LIVRAISON -->
    <div class="table-wrapper">
        @if($order->lieu == "A livrer")
        <h2>Adresse de livraison</h2>
        <div class="fi-ta">
            <div class="fi-ta-ctn">
                <div class="searchZone"></div>
                <div class="fi-ta-content">
                    <table class="fi-ta-table">
                        <thead class="fi-ta-thead">
                            <tr class="fi-ta-tr">
                                <th class="fi-ta-header-cell px-3 py-3.5 sm:first-of-type:ps-6 sm:last-of-type:pe-6 fi-table-header-cell-order-items-count"><span class="fi-ta-header-cell-label text-sm font-semibold text-gray-950 dark:text-white">Nom</span></th>
                                <th>Ville</th>
                                <th>Commune</th>
                                <th>Quartier</th>
                                <th>Adresse</th>
                                <th>Point de reference</th>
                                <th>Téléphone</th>
                            </tr>
                        </thead>
    
                        <tbody class="fi-ta-body">
                            <tr>
                                <td class="fi-ta-cell p-0 first-of-type:ps-1 last-of-type:pe-1 sm:first-of-type:ps-3 sm:last-of-type:pe-3 fi-table-cell-nocmd"><div class="fi-ta-text grid w-full gap-y-1 px-3 py-4">{{$adresse->name}}</div></td>
                                <td>{{$adresse->ville}}</td>
                                <td>{{$adresse->commune}}</td>
                                <td>{{$adresse->quartier}}</td>
                                <td>{{$adresse->adresse}}</td>
                                <td>{{$adresse->point_de_reference}}</td>
                                <td>{{$adresse->phone}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- DETAILS DU PAIEMENT -->
    <div class="table-wrapper">
        <h2>Détails de la transaction</h2>
        <div class="fi-ta">
            <div class="fi-ta-ctn">
                <div class="searchZone"></div>
                <div class="fi-ta-content">
                    <table class="fi-ta-table">
                        <thead class="fi-ta-thead">
                            <tr class="fi-ta-tr">
                                <th>Mode de paiement</th>
                                <th>Rabais</th>
                                <th>Status</th>
                                <th>Total</th>
                            </tr>
                        </thead>
    
                        <tbody class="fi-ta-tbody">
                            <tr>
                                <td class="">{{ $transaction->mode_payement ?? '' }}</td>
                                @if($order->discount == 0)
                                    <td class="">0</td>
                                @else
                                    <td class="">{{str_replace(',','.',number_format($order->discount, 0))}} GNF</td>
                                @endif
                                <td class="">
                                    @if($transaction->status == 'Approuvée')
                                        <span class="badge bg-success" >Approuvée</span>
                                    @elseif($transaction->status == 'Annulée')
                                        <span class="badge bg-danger" >Annulée</span>
                                    @elseif($transaction->status == 'Remboursée')
                                        <span class="badge bg-secondary" >Remboursée</span>
                                    @else
                                        <span class="badge bg-warning" >En attente</span>
                                    @endif
                                </td>
                                <td class="">{{str_replace(',','.',number_format($order->total, 0))}} GNF</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
