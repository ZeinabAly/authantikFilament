<link rel="stylesheet" href="{{ asset('css/filament/pages/view-order.css') }}">

<x-filament-panels::page>
<div class="">
    <livewire:admin.order.view-order :order="$order"/>
</div>
</x-filament-panels::page>
