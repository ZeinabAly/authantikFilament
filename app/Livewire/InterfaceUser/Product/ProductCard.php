<?php

namespace App\Livewire\InterfaceUser\Product;

use Livewire\Component;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Models\Product;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class ProductCard extends Component
{
    public $product;

    public function mount($product){
        $this->product = $product;
    }

    public function addToCart(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);

        $cartService->addProduct($product);
        $this->dispatch('cartUpdated');
    }

    
    public function removeFromCart($productId)
    {
        Cart::instance('cart')->remove($productId);
    }

    public function buyNow($productId){
        $product = Product::find($productId);

        
        Cart::instance('buy_now')->destroy(); 
        Cart::instance('buy_now')->add([
            'id' => $product['id'],
            'name' => $product['name'],
            'qty' => 1,
            'price' => $product['sale_price'] ?? $product['regular_price'],
        ])->associate('App\Models\Product');

        // Rediriger vers une page de paiement
        return redirect()->route('cart.checkout', ['instance' => 'buy_now']);
    }

    public function addToWishlist(CartService $cartService, $productId){
        $product = Product::find($productId);
        if (!$product) {
            session()->flash('error', 'Produit introuvable.');
            return;
        }

        $wishlistItem = Cart::instance('wishlist')->content()->firstWhere('id', $product->id);
        if($wishlistItem){
            Cart::instance('wishlist')->remove($wishlistItem->rowId);
            $this->dispatch('wishlistUpdated');
        }
        else{
            $cartService->addToWishlist($product);
            $this->dispatch('wishlistUpdated');
        }
    }

    public function render()
    {
        return view('livewire.interface-user.product.product-card');
    }
}
