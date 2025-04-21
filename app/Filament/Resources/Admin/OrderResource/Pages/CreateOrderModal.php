<?php

namespace App\Filament\Resources\Admin\OrderResource\Pages;

use App\Filament\Resources\Admin\OrderResource;
use Filament\Resources\Pages\Page;
// OrderModal de l'autre appli
use Livewire\Attributes\On;
use App\Services\CartService;
use App\Services\OrderService;
use App\Services\CheckoutService;
use App\Jobs\OrderNotificationJob;
use Illuminate\Support\Facades\Session;
use App\Models\{Product, SousCategory, Address, User};

class CreateOrderModal extends Page
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.admin.order-resource.pages.create-order-modal';

    
}
