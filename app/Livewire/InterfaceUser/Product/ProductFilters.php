<?php

namespace App\Livewire\InterfaceUser\Product;

use Livewire\Component;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use App\Models\{SousCategory, Product};
use Livewire\WithPagination;
use Illuminate\Support\Facades\Session;
use App\Services\CartService;
use App\Services\CheckoutService;
use App\Services\OrderService;
use Livewire\Attributes\On;



#[On('userLogged')]
class ProductFilters extends Component
{
    use WithPagination;
    // Propriétés pour les filtres
    public $selectedCategory = '';
    public $minPrice = 10000;
    public $maxPrice = 1000000;
    public $search = '';
    public $order = '';
    public $nbreProducts = '';
    

    
    //Ecouteur pour rafraichir lors des changements
    protected $listeners = [
        'refresProducts' => '$refresh',
        // 'priceRangeUpdated' => 'updatePriceRange',
        'updatePriceRange' => 'setPriceRange'
    ];

    public function setPriceRange($min, $max)
    {
        $this->minPrice = $min;
        $this->maxPrice = $max;
    }

    // METTRE LE PARAMETRE DE RECHERCHE DANS L'URL
    protected $queryString = [
        'search' => ['except' => '']
    ];
    

    // PAGINATION PERSONNALISEE


    public function mount()
    {
        $this->nbreProducts = Product::count();
        // $this->minPrice = Product::min('regular_price');
        // $this->maxPrice = Product::max('regular_price');
        // $this->products = Product::all();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    // AJOUTER LA CATEGORIE SELECTIONEE AU TABLEAU
    public function selectCategory($id)
    {
        $this->selectedCategory = $id; 
        $this->resetPage();
    }

    // Surveiller les changements de propriétés

    // public function resetFilters(){
    //     $this->selectedCategory = '';
    //     $this->minPrice = Product::min('regular_price');
    //     $this->maxPrice = Product::max('regular_price');
    //     $this->search = '';
    //     $this->resetPage();
    // }


    // POUR NE PAS ENCOMBRER RENDER JE SEPARE LES FILTRES DANS D'AUTRES METHODES
    public function getFilteredProducts()
    {

        if($this->selectedCategory == ""){
            return Product::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->when($this->order, function($query) {
                $this->applyOrder($query);
            })
            ->paginate(12);
        }else{
            return Product::query()
                ->where('sousCategory_id', $this->selectedCategory)
                ->where('name', 'like', '%' . $this->search . '%')
                ->when($this->order, function($query) {
                    $this->applyOrder($query);
                })
                ->paginate(12);
        }
    }

    public function addToCart(CartService $cartService, $productId, CheckoutService $checkoutService){
        $product = Product::find($productId);

        $cartItem = Cart::instance('cart')->content()->firstWhere('id', $product->id);

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
    

        $wishlistItem = Cart::instance('wishlist')->content()->firstWhere('id', $product->id);

        if($wishlistItem){
            Cart::instance('wishlist')->remove($wishlistItem->rowId);
            $this->dispatch('wishlistUpdated');
        }
        else{
            $cart = $cartService->addToWishlist($product);
            $this->dispatch('wishlistUpdated');
        }

    }

    public function applyOrder($query)
    {
        switch($this->order) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('regular_price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('regular_price', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('name', 'asc');
        }
    }

    public function render()
    {
        $sousCategories = SousCategory::get();
        $featuredProducts = Product::where('featured', 1)->inRandomOrder()->take(4)->get();
        $productSuggeres = Product::inRandomOrder()->take(6)->get();
        // LES FILTRES
        $products = $this->getFilteredProducts();
        
        // if($this->search){
        //     $products = $products->where('name', 'like', '%' . $this->search . '%')->paginate(12);
        // }else{
        //     $products = $products->paginate(12);
        // }
        
        return view('livewire.interface-user.product.product-filters', [
            "sousCategories" => $sousCategories,
            "products" => $products,
            "featuredProducts" => $featuredProducts,
            "productSuggeres" => $productSuggeres,
            // "maxPriceValue" => Product::max('regular_price'),
            // "minPriceValue" => Product::min('regular_price'),
        ]);
    }
}

