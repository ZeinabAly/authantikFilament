<?php

namespace App\Livewire\InterfaceUser\PanierWishlist;

use Livewire\Component;
use App\Services\CartService;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistManager extends Component
{
    public $items;


    public function removeProductToWishList(CartService $cartService, $rowId)
    {
        $cartService->removeProductToWishList($rowId);
        $this->dispatch('wishlistUpdated');
        return session()->flash('success', 'Produit supprimé de la liste des favoris');
    }

    public function resetWishList(CartService $cartService)
    {
        $cartService->resetWishList();
        $this->dispatch('wishlistUpdated');
        return session()->flash('success', 'Vous a vidé la liste des favoris');
    }

    public function moveWishListToProduct($rowId, CartService $cartService){
        $cartService->moveWishListToProduct($rowId);
        $this->dispatch('wishlistUpdated');
        $this->dispatch('cartUpdated');
        return session()->flash('success', 'Le produit a été déplacé vers le panier');
    }
    
    public function render()
    {

        $items = Cart::instance('wishlist')->content();

        return view('livewire.interface-user.panier-wishlist.wishlist-manager', [
            'items' => $items
        ]);
    }
}
