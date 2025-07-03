<?php

namespace App\Livewire\InterfaceUser\Product;

use Livewire\Component;
use Jorenvh\Share\ShareFacade as Share;
use App\Models\Product;

class ShareProduct extends Component
{
    public Product $product;
    public string $shareUrl;
    public array $shareLinks;

    public function mount(Product $product){
        $this->product = $product;
        // Générer l'URL complète du produit
        $this->shareUrl = route('product.view', $product->slug);
        // Générer les liens de partage avec Laravel Share
        $this->shareLinks = Share::page(
            $this->shareUrl, 
            $product->name, 
            [
                'title' => $product->name,
                'description' => $product->description ?? 'Découvrez ce produit',
                'image' => $product->image ? asset('storage/uploads/products'.$product->image) : null
            ])
              ->facebook()
              ->twitter()
              ->whatsapp()
            //   ->instagram()
              ->getRawLinks();

        // $this->shareLinks sera un tableau associatif ['facebook' => 'url', 'twitter' => 'url', ...]
    }

    public function render()
    {
        return view('livewire.interface-user.product.share-product');
    }
}
