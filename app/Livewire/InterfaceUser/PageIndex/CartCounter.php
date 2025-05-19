<?php

namespace App\Livewire\InterfaceUser\PageIndex;

use Livewire\Component;
use Livewire\Attributes\On;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartCounter extends Component
{
    public $cartCount = 0;
    public $wishlistCount = 0;
    
    public function mount()
    {
        $this->cartCount = Cart::instance('cart')->content()->count();
    }
    
    #[On('cartUpdated')]
    public function refreshCartCount()
    {
        $this->cartCount = Cart::instance('cart')->content()->count();
        // $this->resetPage();
    }
    #[On('wishlistUpdated')]
    public function refreshWishlistCount()
    {
        $this->wishlistCount = Cart::instance('wishlist')->content()->count();
    }

    public function render()
    {
        return view('livewire.interface-user.page-index.cart-counter', [
            'cartCount' => $this->cartCount,
        ]);
    }
}
