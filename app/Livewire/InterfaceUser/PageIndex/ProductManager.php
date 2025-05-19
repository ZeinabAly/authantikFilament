<?php

namespace App\Livewire\InterfaceUser\PageIndex;

use Livewire\Component;
use App\Models\{Product, SousCategory};
use Illuminate\Support\Facades\Session;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;

use Surfsidemedia\Shoppingcart\Facades\Cart;

class ProductManager extends Component
{
    public $slideProducts = [''];


    public function mount(){
        $this->slideProducts = Product::take(20)->inRandomOrder()->get();
    }

    public function addToCart(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);
        $cartService->addProduct($product);
        $this->dispatch('cartUpdated');
    }
    
    public function addToWishlist(CartService $cartService, $productId){
        $product = Product::find($productId);
        $wishlistItem = Cart::instance('wishlist')->content()->firstWhere('id', $product->id);
        if($wishlistItem){
            Cart::instance('wishlist')->remove($wishlistItem->rowId);
            $this->dispatch('wishlistUpdated');
        }else{
            $cartService->addToWishlist($product);
            $this->dispatch('wishlistUpdated');
        }
    }
    public function render()
    {
        return view('livewire.interface-user.page-index.product-manager');
    }
}
