<?php

namespace App\Livewire\InterfaceUser\About;

use Livewire\Component;
use App\Models\{Product, SousCategory};
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Services\CartService;
use App\Services\CheckoutService;


class ProductByCategory extends Component
{
    // public $sousCategorySelected = '';
    public $selectedCategory = '';
    public $products = [];
    public $sousCategories = [];

    public function mount(){
        $this->products = Product::limit(4)->get();
        $this->sousCategories = SousCategory::all();
    }
    // AJOUTER LA CATEGORIE SELECTIONEE AU TABLEAU
    public function selectCategory($id)
    {
        $this->selectedCategory = $id; 
    }

    // public function sousCatUpdate($id){

    //     $this->sousCategorySelected = $id;
    //     $this->products = Product::where('sousCategory_id', $id)->take(4)->get();
    //     if($id == ""){
    //         $this->products = Product::take(4)->get();
    //     }
    // }

    public function addToCart(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);

        $cartService->addProduct($product);
        $this->dispatch('cartUpdated');
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
        $this->products = Product::where('sousCategory_id', $this->selectedCategory)->limit(4)->get();

        if($this->selectedCategory == ""){
            $this->products = Product::take(4)->get();
        }

        return view('livewire.interface-user.about.product-by-category', [
            'products' => $this->products
        ]);
    }
}
