<div x-data = "{confirmDelete: false}">
    <div class="notification-filters">
        <button type="button" wire:click="choiceNotifType('toutes')" class="filter-btn {{$typeNotif == 'toutes' ? 'active' : ''}}">Toutes</button>
        <button type="button" wire:click="choiceNotifType('commande')"  class="filter-btn {{$typeNotif == 'commande' ? 'active' : ''}}">Commandes</button>
        <button type="button" wire:click="choiceNotifType('reservation')"  class="filter-btn {{$typeNotif == 'reservation' ? 'active' : ''}}">Réservations</button>
        <button type="button" wire:click="choiceNotifType('nonLu')"  class="filter-btn {{$typeNotif == 'nonLu' ? 'active' : ''}}">Non lues</button>
    </div>

    <div class="notifications-list">
        @forelse($notifications as $notification)
            
            <div class="notification-card {{ $notification->read_at ? '' : 'unread' }}">
                <div class="notification-content">
                    <div class="notif-icon_details">
                        <div class="notification-icon {{ $notification->type == 'App\Notifications\ReservationNotification' ? 'icon-reservation' : 'icon-connection' }}">
                            @if($notification->type == "App\Notifications\ReservationNotification")
                                <x-icon name="user-vide" size="25" fill="#fff"/>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            @endif
                        </div>
                        <div class="notification-details">
                            <div class="notification-header">
                                <span class="notification-title">
                                    @if($notification->type == "App\Notifications\ReservationNotification")
                                        Nouvelle réservation
                                    @else
                                        Nouvelle commande
                                    @endif
                                </span>
                                <span class="notification-time">{{ $notification->created_at->locale('fr')->diffForHumans() }}</span>
                            </div>
                            <p class="notification-message">{{ $notification->data['name'] }}</p>
                        </div>
                    </div>
                    <div class="notification-footer">
                        <span class="notification-user">{{$notification->created_at->format('Y-m-d') }}  - {{ $notification->data['heure'] ??  $notification->created_at->format("H:i:s")}}</span>
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
