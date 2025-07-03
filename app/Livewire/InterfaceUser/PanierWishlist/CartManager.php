<?php

namespace App\Livewire\InterfaceUser\PanierWishlist;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;

class CartManager extends Component
{
    public $cartContent = [];
    public $total = 0;
    public $modePayement = '';

    public $couponCode = '';


    public function clearCart(CartService $cartService, CheckoutService $checkoutService){
        $cartService->resetCart();
        $this->total = $cartService->getCartTotal();
        
        $checkoutService->remove_coupon_code();

        $this->dispatch('cartUpdated');

        return session()->flash('success', 'Vous avez vidé votre panier');

    }

    public function increaseQuantity(CartService $cartService, $rowId, CheckoutService $checkoutService){
        $cartService->increaseQuantity($rowId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }
    }

    public function decreaseQuantity(CartService $cartService, $rowId, CheckoutService $checkoutService){
        $cartService->decreaseQuantity($rowId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];
        }
        else{
            $this->total = $cartService->getCartTotal();
        }
    }

    public function removeProduct(CartService $cartService, $rowId, CheckoutService $checkoutService){
        
        $cartService->removeProduct($rowId);
        $this->dispatch('cartUpdated');

        if(Session::has('discounts')){

            $checkoutService->calculateDiscount();
            $checkoutService->calculateCheckout();
            $this->total = Session::get('discounts')['total'];

        }
        else{
            $this->total = $cartService->getCartTotal();
        }

        return session()->flash('success', 'Produit supprimé de la carte');

    }

    public function getCartTotal(CartService $cartService){
        $this->total = $cartService->getCartTotal();
        $this->dispatch('cartUpdated');
    }

    public function applyCoupon(CheckoutService $checkoutService){

        $checkoutService->apply_coupon_code($this->couponCode);
        
    }

 
    public function getModePayemeent($mode){
        $this->modePayement = $mode;
    }


    public function render()
    {
        return view('livewire.interface-user.panier-wishlist.cart-manager');
    }
}
