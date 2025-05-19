<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Jobs\SendRerservationNotificationJob;
use App\Models\Reservation;

class CartController extends Controller
{
    public function index(){
        $items = Cart::instance('cart')->content();
        return view('pagesInterfaceFront.cart-wishlist.cart', compact('items'));
    }

    public function checkout(){
        $items = Cart::instance('cart')->content();
        if($items->count() <= 0){
            return redirect()->route('home.menu')->with('cartVide', 'Votre panier est vide ! ');
        }
        return view('pagesInterfaceFront.cart-wishlist.checkout', compact('items'));
    }

    public function orderConfirmation(){
        // $items = Cart::instance('items')->content();
        return view('pagesInterfaceFront.cart-wishlist.order-confirmation');
    }

    public function wishlist(){
        
        $items = Cart::instance('wishlist')->content();

        return view('pagesInterfaceFront.cart-wishlist.wishlist', compact('items'));
    }
}
