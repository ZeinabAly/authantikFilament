<div x-data = "{confirmDelete: false}">
    <!-- LES TABS (RESERVATION, COMMANDE, MESSAGE, NON LUE) -->
    <div class="notification-filters">
        <button type="button" wire:click="choiceNotifType('toutes')" class="filter-btn {{$typeNotif == 'toutes' ? 'active' : ''}}">Toutes</button>
        <button type="button" wire:click="choiceNotifType('commande')"  class="filter-btn {{$typeNotif == 'commande' ? 'active' : ''}}">Commandes</button>
        <button type="button" wire:click="choiceNotifType('reservation')"  class="filter-btn {{$typeNotif == 'reservation' ? 'active' : ''}}">Réservations</button>
        <button type="button" wire:click="choiceNotifType('contact')"  class="filter-btn {{$typeNotif == 'contact' ? 'active' : ''}}">Message</button>
        <button type="button" wire:click="choiceNotifType('nonLu')"  class="filter-btn {{$typeNotif == 'nonLu' ? 'active' : ''}}">Non lues</button>
    </div>

    <div class="notifications-list">
        @forelse($notifications as $notification)
            
            <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
                <div class="notification-content">
                    <div class="notif-icon_details">

                        <!-- NOTIF HEADER -->
                        <div class="notifications-header">
                            <!-- LES ICONES -->
                            <div class="notification-icon {{ $notification->type == 'App\Notifications\ReservationNotification' ? 'icon-reservation' : 'icon-connection' }}">
                                
                                @if($notification->type == "App\Notifications\ReservationNotification")
                                    <x-icon name="reservation" size="22" fill="#ebebeb" color="#fff"/>
                                @elseif($notification->type == "App\Notifications\OrderNotification")
                                    <x-icon name="dollar-sign" size="20" fill="#fff"/>
                                @elseif($notification->type == "App\Notifications\ContactUsNotification")
                                    <x-icon name="enveloppe" size="20" fill="#fff"/>
                                @endif
    
                            </div>
    
                            <!-- TITRE ET HEURE -->
                            <div class="titre-heure">
                                <h4 class="notification-title">
                                    {{ array_key_exists('title', $notification->data) ? $notification->data['title'] : 'Nouveau message' }}
                                </h4>
                                <p class="notification-time">{{ $notification->created_at->locale('fr')->diffForHumans() }}</p>
                            </div>
                        </div>

                        <div class="notification-details">
                            <!-- NO DE COMMANDE ET NOM DU CLIENT -->
                            <div>
                                @if(array_key_exists('nocmd', $notification->data))
                                <p class="notif-body" ><span>N° : </span> {{ $notification->data['nocmd'] }}</p>
                                @endif
                                <p class="notif-body" ><span>Nom client:</span> {{ $notification->data['name'] ?? '' }}</p>
                            </div>
                            
                            <!-- NOMBRE DE PRODUITS ET TOTAL -->
                            <div class="">

                                @if(array_key_exists('nbrPrdt', $notification->data))
                                <div class="notif-body"><span>Nombre de produits :</span> {{ $notification->data['nbrPrdt'] ?? '' }}</div>
                                @endif

                                @if(array_key_exists('total', $notification->data))
                                <div class="notif-body"><span>Total :</span> {{ $notification->data['total'] ?? '' }} GNF</div>
                                @endif

                            </div>
                            
                            <!-- NOM DU SERVEUR -->
                            @if(array_key_exists('serveur', $notification->data) && $notification->data['serveur'] !== "")
                            <div class="notif-body"><span>Nom serveur :</span> {{ $notification->data['serveur'] }}</div>
                            @endif

                            <div class="">

                                <!-- DATE ET HEURE -->
                                <div class="">
                                    @if(array_key_exists('date', $notification->data))
                                        <div class="notif-body"><span>{{$notification->type === "App\Notifications\ReservationNotification" ? "Pour le" : "Date"}}</span> : {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->translatedFormat('d F Y') }}</div>
                                    @endif
                                    
                                    @if(array_key_exists('heure', $notification->data))
                                        <div class="notif-body"><span>Heure :</span> {{ \Carbon\Carbon::parse($notification->data['heure'])->format('H:i') }}</div>
                                    @endif
                                </div>

                                <!-- LISTE DE PRODUITS -->
                                @if(array_key_exists('produits', $notification->data) && !empty($notification->data['produits']))
                                    <div class="notif-body">
                                        <span>Message :</span> 
                                        @foreach($notification->data['produits'] as $produit)
                                        <span>{{$produit->name}} , </span> 
                                        @endforeach
                                    </div>
                                @endif

                                <!-- MESSAGE -->
                                @if(array_key_exists('message', $notification->data))
                                    <div class="notif-body"><span>Message :</span> {{ Str::limit($notification->data['message'], 50) }}</div>
                                @endif
                            </div>
                            
                        </div>
                        </div>

                        <div class="notification-footer">
                            <span class="notification-user">{{$notification->created_at->format('Y-m-d') }}</span>
                            <div class="notification-actions">
                                @if(!$notification->read_at)
                                    <button wire:click="markAsRead('{{$notification->id}}')" class="action-btn mark-read bg-gray-200 text-black"><x-icon name="mark-as-read" fill="#2196f3" /></button>
                                @endif
                                <button @click="confirmDelete = true" class="action-btn delete-btn bg-red-200 text-black"><x-icon name="delete"  /></button>
                            </div>

                        </div>
                    </div>
            </div>

            <!-- CONFIRMATION DE SUPPRESSION -->
            <div x-show="confirmDelete" x-cloak class="confirmationBox" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"  x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95">
                <div class="confirmationContent">
                    <h3 class="text-lg font-bold mb-4">Supprimer la notification</h3>
                    <p class="mb-4">Êtes-vous sûr de vouloir supprimer cette notification ?</p>
                    <div class="flex justify-end gap-2">
                        <button @click="confirmDelete = false" class="btnAnnulerCmd">
                            Annuler
                        </button>
                        <button wire:click="delete('{{$notification->id}}')" @click="confirmDelete = false" class="btnConfirmerCmd" style="background: #8b0f0f">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-notifications">
                <p>Vous n'avez aucune notification pour le moment.</p>
            </div>
        @endforelse
    </div>


    <div class="pagination-container">
        {{ $notifications->links() }}
    </div>
</div>
