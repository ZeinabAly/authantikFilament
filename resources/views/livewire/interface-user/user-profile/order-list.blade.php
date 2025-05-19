<div>
    <!-- Search zone -->
    <div class="">
        <!-- PLACE DES FILTRES -->
        @include('partials.pagesIndexAdmin.header')
        
    </div>

    <div class="table-wrapper">
        <table class="table border">
            <thead class="thead">
                @include('partials.pagesIndexAdmin.thead')
            </thead>
            <tbody class="tbody">
                @if($search && $orders[0] == null)
                    <tr class="colsTbody">
                        <td colspan="9" class="colsTbody">
                            Aucune commande trouvée pour "{{ $search }}"
                        </td>
                    </tr>
                @endif
                @foreach($orders as $order)
                <tr class="">
                    <td class="w-4 py-4 px-2">
                        <div class="flex items-center">
                            <input type="checkbox" id="checkbox-{{ $order->id }}" wire:click="toggleSelection({{ $order->id }})" @if($selectAll || in_array($order->id, $selectedRows) ) checked @endif >
                            <label for="checkbox-{{ $order->id }}" class="sr-only">checkbox</label>
                        </div>
                    </td>

                    @if (in_array('NoCMDParJour', $columns))
                    <td scope="row" class="colsTbody">
                        {{ $order->NoCMDParJour }}
                    </td>
                    @endif

                    @if (in_array('name', $columns))
                    <td scope="row" class="colsTbody text-center font-bold">
                        {{ $order->name }}
                    </td>
                    @endif

                    @if (in_array('phone', $columns))
                    <td scope="row" class="colsTbody">
                        {{ $order->phone }}
                    </td>
                    @endif

                    {{--@if (in_array('nbrePrdts', $columns))
                    <td scope="row" class="colsTbody">
                        {{ $order->orderItems->count() }}
                    </td>
                    @endif--}}

                    @if (in_array('total', $columns))
                    <td scope="row" class="colsTbody font-bold">
                        {{ str_replace(',','.',number_format($order->total, 0)) }} GNF
                    </td>
                    @endif

                    @if (in_array('status', $columns))
                    <td class="colsTbody">
                        @if($order->lieu == 'Sur place')
                            Reçue
                        @else
                            @if($order->status == 'delivred')
                            <span class="badge bg-success">Livré</span>
                            @elseif($order->status == 'canceled')
                            <span class="badge bg-danger">Annulé</span>
                            @else 
                            <span class="badge bg-warning">En attente</span>
                            @endif

                        @endif
                    </td>
                    @endif
                    
                    @if (in_array('lieu', $columns))
                    <td scope="row" class="colsTbody">
                        {{ $order->lieu }}
                    </td>
                    @endif

                    @if (in_array('created_at', $columns))
                    <td scope="row" class="colsTbody">
                        {{ $order->created_at }}
                    </td>
                    @endif
                    
                    @if (in_array('delivred_date', $columns))
                    <td scope="row" class="colsTbody">
                        @if($order->lieu == 'Sur place')
                        {{ $order->created_at }}
                        @else
                        {{ $order->delivred_date }}
                        @endif
                    </td>
                    @endif
                    
                    
                    @if (in_array('action', $columns))
                    <td class="colsTbody">
                        <div class="divIconsActions">
                            <div x-data="{ options: false }" @click.outside="options = false" class="relative  text-left">

                                <button @click="options = !options" class=""><x-icon name="trois-points" size="16" fill="#595b60"/></button>

                                <div x-show="options" class="min-w-[200px] w-full min-w-[100px] py-1 bg-[#e4e5e8] rounded-sm shadow-md leading-[30px] text-left absolute top-1 z-10 right-4">
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <a href="{{ route('myprofile.commande.details', ['order' => $order] ) }}">
                                            Voir
                                        </a>
                                    </div>

                                    @if($order->status !== "Livrée" && $order->status !== "Annulée")
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <x-annulerCmd class="py-2 px-4 rounded-md bg-red-700 font-bold text-white text-[15px]"/>
                                    </div>
                                    @endif

                                    @if($order->status !== "Livrée" && $order->status !== "Annulée")
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <livewire:interface-user.user-profile.edit-order-modal :order=$order />
                                    </div>
                                    @endif
                                    
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <x-deleteBtn :id="$order->id" :icon="false" />                                    
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <div class="flexBetween mx-4">
            @include('partials.pagesIndexAdmin.footer')
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$orders->links('pagination::dashBoardPagination')}}
            </div>
        </div>
    </div>

</div>
