<link rel="stylesheet" href="{{ asset('css/filament/pages/edit-order.css') }}">
<link rel="stylesheet" href="{{ asset('css/filament/pages/dashboard.css') }}">

<x-filament-panels::page>
<div class="">
    <livewire:client.order.edit-order :order="$order"/>
</div>
</x-filament-panels::page>
