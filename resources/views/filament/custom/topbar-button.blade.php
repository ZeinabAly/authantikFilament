
<div x-data="{openModal: false}" x-cloak>
    <link rel="stylesheet" href="{{ asset('css/filament/pages/modal-styles.css') }}">
    <button type="button" @click="$dispatch('open-order-modal')" class="btnCommander">
        Passer une commande
    </button>
</div>
