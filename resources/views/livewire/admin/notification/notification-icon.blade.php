<div>
{{--
<div class="flexCenter gap-3">
    <a href="{{$panelId === 'client' ? route('filament.client.pages.notifications') : route('filament.admin.pages.notifications')}}">
        <div class="notifIconBox">
            <x-icon name="notification" fill="#f2f2f2" size="20" class="notifIcon" class="iconNotifDark"/>
            <x-icon name="notification" fill="#1A1F2C" size="20" class="notifIcon" class="iconNotif"/>
            <span class="nbreNotifs">{{ $nbreNotifs }}</span>
        </div>
    </a>
</div> --}}

<div x-data="{ open: false }" class="notif-container">
    <button class="notif-bell" @click="open = true">🔔</button>

    <div class="" x-show="open" @click.outside="open = false" x-show="open"
            x-transition:enter="slide-enter"
            x-transition:leave="slide-leave">
        <div class="notif-drawer  relative grid min-h-full grid-rows-[1fr_auto_1fr] justify-items-center sm:grid-rows-[1fr_auto_3fr]">
            <div class="notifs">
                <div class="notif-header">
                    <h2>Notifications</h2>
                    <button @click="open = false" class="notif-close">✕</button>
                </div>
        
                <div class="notif-list">
                    @foreach(auth()->user()->unreadNotifications as $notification)
                        <div class="notif-card">
                            <div class="notif-title">{{ $notification->data['title'] ?? 'Notification' }}</div>
                            <div class="notif-body">{{ $notification->data['body'] ?? '' }}</div>
                            <form method="POST" action="route('notifications.markAsRead', $notification->id) }}">
                                @csrf
                                <button class="notif-action">✔ Marquer comme lu</button>
                            </form>
                        </div>
                    @endforeach
        
                    @if(auth()->user()->unreadNotifications->isEmpty())
                        <div class="notif-empty">Aucune notification pour le moment.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<script>
    let btnNotif = document.querySelector('.notif-bell');
    let btnCloseNotif = document.querySelector('.notif-close');
    let body = document.body;

    btnNotif.addEventListener('click', function() {
        body.style.overflow = 'hidden'; 
    });
    btnCloseNotif.addEventListener('click', function() {
        body.style.overflow = 'scroll'; 
    });
</script>