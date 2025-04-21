<?php
namespace App\Services;

use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class CartService
{
    /**
     * Ajouter un produit au panier.
     */
    public function addProduct($product, $options = [])
    {
        
        $cart = Cart::instance('cart')->add([
            'id' => $product['id'],
            'name' => $product['name'],
            'qty' => 1,
            'price' => $product['sale_price'] ?? $product['regular_price'],
            'options' => [$options],
        ])->associate('App\Models\Product');

        $cart->setTaxRate(0);

        return $cart;
    }

    /**
     * Mettre à jour la quantité d'un produit dans le panier.
    */
    public function increaseQuantity($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        
        Cart::instance('cart')->update($rowId, ['qty' => $product->qty + 1]);
    }

    public function decreaseQuantity($rowId)
    {

        $product = Cart::instance('cart')->get($rowId);
        if($product->qty > 1){
            Cart::instance('cart')->update($rowId, ['qty' => $product->qty - 1]);
        }
    }

    /**
     * Supprimer un produit du panier.
     */
    public function removeProduct($productId)
    {
        Cart::instance('cart')->remove($productId);
    }

    
    public function getCartItem($rowId){
        return Cart::instance('cart')->get($rowId);
    }
    
    public function getWishlistItem($rowId){
        return Cart::instance('wishlist')->get($rowId);
    }


    /**
     * Réinitialiser le panier.
     */
    public function resetCart()
    {
        Cart::instance('cart')->destroy();
    }

    /**
     * Récupérer le contenu du panier.
     */
    public function getCartContent()
    {
        return Cart::instance('cart')->content();
    }

    public function getWishlistContent()
    {
        return Cart::instance('wishlist')->content();
    }


    /**
     * Obtenir le total du panier.
     */
    public function getCartTotal()
    {
        return Cart::instance('cart')->total();
    }

    // WISHLIST

    public function addToWishlist($product){

        $whish = Cart::instance('wishlist')->add([
                'id' => $product['id'],
                'name' => $product['name'],
                'qty' => 1,
                'price' => $product['sale_price'] ?? $product['regular_price'],
            ])->associate('App\Models\Product');
        
        return $whish;
    }

    public function removeProductToWishList($rowId)
    {
        Cart::instance('wishlist')->remove($rowId);
    }

    public function moveWishListToProduct($rowId)
    {
        $productId = $this->getWishlistItem($rowId)->id;
        $product = Product::findOrFail($productId);

        $this->addProduct($product);
        Cart::instance('wishlist')->remove($rowId);
    }

    public function resetWishList()
    {
        Cart::instance('wishlist')->destroy();
    }
}
