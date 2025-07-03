<div>

<div x-data="{ open: false }" class="fi-modal-window max-w-md">
 
    <!-- BOUTON D'ACTION -->
    <button @click="open = true" style="--c-300:var(--gray-300);--c-400:var(--gray-400);--c-500:var(--gray-500);--c-600:var(--gray-600);" class="icon-notif fi-icon-btn relative flex items-center justify-center rounded-lg outline-none transition duration-75 focus-visible:ring-2 -m-1.5 h-9 w-9 text-gray-400 hover:text-gray-500 focus-visible:ring-primary-600 dark:text-gray-500 dark:hover:text-gray-400 dark:focus-visible:ring-primary-500 fi-color-gray fi-topbar-database-notifications-btn" title="Ouvrir les notifications" type="button" wire:loading.attr="disabled">
            <svg class="fi-icon-btn-icon h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0"></path>
            </svg>

            <div class="fi-icon-btn-badge-ctn absolute start-full top-1 z-[1] w-max -translate-x-1/2 -translate-y-1/2 rounded-md bg-white dark:bg-gray-900 rtl:translate-x-1/2">
                <span style="--c-50:var(--primary-50);--c-400:var(--primary-400);--c-600:var(--primary-600);" class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-0.5 min-w-[theme(spacing.4)] tracking-tighter fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30 fi-color-primary">
            
                    <span class="grid">
                        <span class="truncate">
                            {{$nbreNotifs}}
                        </span>
                    </span>

                </span>
            </div>
    </button>

    <!-- CONTENU DE LA MODALE -->
    <div class="notifModalContent fi-modal-close-overlay fixed inset-0 z-40 bg-gray-950/50 dark:bg-gray-950/75" x-show="open" @click.outside="open = false" x-show="open" x-transition:enter="duration-300" x-transition:leave="duration-300" x-transition:enter-start="translate-x-full rtl:-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full rtl:-translate-x-full">
        <div class="notif-drawer grid min-h-full">
            <div class="notifs">
                <div class="fi-modal-header px-6 pt-6 fi-sticky sticky top-0 z-10 border-b border-gray-200 bg-white pb-6 dark:border-white/10 dark:bg-gray-900 gap-x-5">
                    <h2 class="notif-header">
                        <span class="relative">
                            Notifications
                            <span style="--c-50:var(--primary-50);--c-400:var(--primary-400);--c-600:var(--primary-600);" class="fi-badge flex items-center justify-center gap-x-1 rounded-md text-xs font-medium ring-1 ring-inset px-0.5 min-w-[theme(spacing.4)] tracking-tighter fi-color-custom bg-custom-50 text-custom-600 ring-custom-600/10 dark:bg-custom-400/10 dark:text-custom-400 dark:ring-custom-400/30 fi-color-primary absolute -top-1 start-full ms-1 w-max">
                                <span class="grid">
                                    <span class="truncate">
                                        {{$nbreNotifs}}
                                    </span>
                                </span>
                            </span>
                        </span>
                        <button @click="open = false" class="notif-close">✕</button>
                    </h2>
                    <div class="btnActions">
                        <button class="btnToutMarquer" wire:click="toutMarquer">Tout marquer comme lu</button>
                        <button class="btnToutEffacer" wire:click="toutEffacer">Effacer</button>
                    </div>
                </div>
        
                <div class="notif-list">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <div class="notif-card">
                            <div class="notif-title">{{ $notification->data['title'] ?? 'Notification' }}</div>
                            <div class="notif-diff-time">{{ $notification->created_at->locale('fr')->diffForHumans() }}</div>
                            <div class="notif-body"><span>Nom :</span> {{ $notification->data['name'] ?? '' }}</div>
                            
                            @if(array_key_exists('nbrPrdt', $notification->data))
                                <div class="notif-body"><span>Nombre de produits :</span> {{ $notification->data['nbrPrdt'] ?? '' }}</div>
                            @endif

                            @if(array_key_exists('serveur', $notification->data) && $notification->data['serveur'] !== "")
                                <div class="notif-body"><span>Nom serveur :</span> {{ $notification->data['serveur'] }}</div>
                            @endif
                            
                            <div class="">
                                @if(array_key_exists('date', $notification->data))
                                    <div class="notif-body"><span>{{$notification->type === "App\Notifications\ReservationNotification" ? "Pour le" : "Date"}}</span> : {{ \Carbon\Carbon::parse($notification->data['date'])->locale('fr')->translatedFormat('d F Y') }}</div>
                                @endif
                                @if(array_key_exists('heure', $notification->data))
                                    <div class="notif-body"><span>Heure :</span> {{ \Carbon\Carbon::parse($notification->data['heure'])->format('H:i') }}</div>
                                @endif
                                @if(array_key_exists('message', $notification->data))
                                    <div class="notif-body"><span>Message :</span> {{ Str::limit($notification->data['message'], 50) }}</div>
                                @endif
                            </div>

                            @if(!$notification->read_at)
                                <button wire:click="markAsRead('{{$notification->id}}')" class="notif-action">Marquer comme lu</button>
                            @endif
                            <button wire:click="delete('{{$notification->id}}')" class="deleteNotif"><x-icon name="delete" /></button>
                        </div>
                    @endforeach
        
                    @if(auth()->user()->unreadNotifications->isEmpty())
                        <div class="notif-empty">Aucune notification pour le moment</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    let btnNotif = document.querySelector('.icon-notif');
    let btnCloseNotif = document.querySelector('.notif-close');
    let body = document.body;

    btnNotif.addEventListener('click', function() {
        body.style.overflow = 'hidden'; 
    });
    btnCloseNotif.addEventListener('click', function() {
        body.style.overflow = 'scroll'; 
    });
</script>

