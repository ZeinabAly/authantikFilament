<div>
    <div class="my-5">

        <div class="">
            <!-- PLACE DES FILTRES -->
            @include('partials.pagesIndexAdmin.header')
        </div>

        <div class="table-wrapper">
            <table class="table">
                {{--<div class="sessionMessage">
                    @if(Session::has('status'))
                        <p class="alert alert-success">{{Session::get('status')}}</p>
                    @endif
                </div>--}}
                <thead class="thead">
                    @include('partials.pagesIndexAdmin.thead')
                </thead>
                <tbody class="tbody">
                    @if($search && $reservations[0] == null)
                        <tr class="colsTbody">
                            <td colspan="9" class="colsTbody">
                                Aucune reservation trouvée pour "{{ $search }}"
                            </td>
                        </tr>
                    @endif
                    @foreach($reservations as $reservation)
                    <tr class="">
                        <td class="w-4 py-4 px-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="checkbox-{{ $reservation->id }}" wire:click="toggleSelection({{ $reservation->id }})" @if($selectAll || in_array($reservation->id, $selectedRows) ) checked @endif >
                                <label for="checkbox-{{ $reservation->id }}" class="sr-only">checkbox</label>
                            </div>
                        </td>

                        @if (in_array('id', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->id }}
                        </td>
                        @endif

                        @if (in_array('name', $columns))
                        <td scope="row" class="col-nom-image">
                            {{ $reservation->name }}
                        </td>
                        @endif

                        @if (in_array('email', $columns))
                        <td scope="row" class="colsTbody">
                            @if($reservation->email == "")
                                ---
                            @else
                                {{ $reservation->email }}
                            @endif
                        </td>
                        @endif

                        @if (in_array('phone', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->phone }}
                        </td>
                        @endif

                        @if (in_array('nbrPers', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->nbrPers }}
                        </td>
                        @endif

                        @if (in_array('created_at', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->created_at }}
                        </td>
                        @endif

                        @if (in_array('date', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->date }}
                        </td>
                        @endif

                        @if (in_array('heure', $columns))
                        <td scope="row" class="colsTbody">
                            {{ $reservation->heure }}
                        </td>
                        @endif

                        @if (in_array('details', $columns))
                        <td scope="row" class="colsTbody">
                            @if($reservation->details == "")
                                Aucun détail
                            @else
                                {{ $reservation->details }}
                            @endif
                        </td>
                        @endif

                        @if (in_array('action', $columns))
                        <td class="colsTbody">
                            <div class="divIconsActions">

                                <div x-data="{ optionsReser: false }" @click.outside="optionsReser = false" class="relative  text-left">

                                    <button @click="optionsReser = !optionsReser" class=""><x-icon name="trois-points" size="16" fill="#595b60"/></button>
                                
                                    <div x-show="optionsReser" class="min-w-[200px] w-full min-w-[100px] py-1 bg-[#e4e5e8] rounded-sm shadow-md leading-[30px] text-left absolute top-1 z-10 right-4">
                                    @if($reservation->statut === "En cours")
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <x-annulerCmd class="py-2 px-4 rounded-md bg-red-700 font-bold text-white text-[15px]"/>
                                    </div>
                                    @endif

                                    @if($reservation->statut == "En cours")
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        Modifier
                                    </div>
                                    @endif
                                    
                                    <div class="item edit w-full hover:bg-white px-4 py-1 text-left text-[14px]">
                                        <x-deleteBtn :id="$reservation->id" :icon="false" />                                    
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
    </div>

    <div class="footer">
        <div class="flexBetween mx-4">
            @include('partials.pagesIndexAdmin.footer')
            <div class="flex items-center justify-between flex-wrap gap10 wgp-pagination">
                {{$reservations->links('pagination::dashBoardPagination')}}
            </div>
        </div>
    </div>
</div>
