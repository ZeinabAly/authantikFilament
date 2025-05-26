<?php

namespace App\Livewire\InterfaceUser\Product;

use Livewire\Component;
use App\Models\{Product, SousCategory};
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;

class ViewProduct extends Component
{

    public $product;
    public $relatedProducts;
    public $cartContent = [];
    public $total = 0;
    public $favoriteRowId;
    public $cartRowId;
    public $imageView;

    public function mount(Product $product){
        $this->product = $product;
        $this->relatedProducts = Product::where('sousCategory_id', '<>', $product->sousCategory)->get();
        $this->imageView = $product->image;
    }


    public function displayImage($image){
        $this->imageView = $image;
    }

    public function addToCart(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);

        $cartItem = Cart::instance('cart')->content()->firstWhere('id', $this->product->id);

        if($cartItem){
            Cart::instance('cart')->remove($cartItem->rowId);
            $this->dispatch('cartUpdated');
        }
        else{
            $cart = $cartService->addProduct($product);
            $this->dispatch('cartUpdated');
        }

    }


    public function addToWishlist($productId, CartService $cartService){
        $product = Product::find($productId);
    

        $wishlistItem = Cart::instance('wishlist')->content()->firstWhere('id', $this->product->id);

        if($wishlistItem){
            Cart::instance('wishlist')->remove($wishlistItem->rowId);
            $this->dispatch('wishlistUpdated');
        }
        else{
            $cart = $cartService->addToWishlist($product);
            $this->dispatch('wishlistUpdated');
        }

    }

    public function increaseQuantity(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);
        $cartItem = Cart::instance('cart')->content()->firstWhere('id', $this->product->id);
        if($cartItem){
            $cartService->increaseQuantity($cartItem->rowId);
            $this->dispatch('cartUpdated');
        }else{
            $cart = $cartService->addProduct($product);
            $this->dispatch('cartUpdated');
        }
    }

    public function decreaseQuantity(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);
        $cartItem = Cart::instance('cart')->content()->firstWhere('id', $this->product->id);
        if($cartItem){
            $cartService->decreaseQuantity($cartItem->rowId);
            $this->dispatch('cartUpdated');
        }
    }

    public function render()
    {
        return view('livewire.interface-user.product.view-product');
    }
}
