<?php

namespace App\Livewire\InterfaceUser\Product;

use Livewire\Component;
use App\Models\Product;

class PriceRangeFilter extends Component
{
    public $minPrice = 1000;
    public $maxPrice = 7000;
    public $min = 100;
    public $max = 10000;
    public $minThumb = 0;
    public $maxThumb = 0;
    public $products = [];

    public function mount()
    {
        $this->calculateThumbs();
        $this->filterProducts();
    }

    public function calculateThumbs()
    {
        $this->minThumb = (($this->minPrice - $this->min) / ($this->max - $this->min)) * 100;
        $this->maxThumb = 100 - ((($this->maxPrice - $this->min) / ($this->max - $this->min)) * 100);
    }

    public function updatedMinPrice()
    {
        $this->minPrice = min((int)$this->minPrice, (int)$this->maxPrice - 500);
        $this->calculateThumbs();
        $this->filterProducts();
        $this->dispatch('price-range-updated', [
            'min' => $this->minPrice,
            'max' => $this->maxPrice
        ]);
    }

    public function updatedMaxPrice()
    {
        $this->maxPrice = max((int)$this->maxPrice, (int)$this->minPrice + 500);
        $this->calculateThumbs();
        $this->filterProducts();
        $this->dispatch('price-range-updated', [
            'min' => $this->minPrice,
            'max' => $this->maxPrice
        ]);
    }

    public function filterProducts()
    {
        
        $this->products = Product::whereBetween('regular_price', [$this->minPrice, $this->maxPrice])
            ->get();
    }
    public function render()
    {
        return view('livewire.interface-user.product.price-range-filter');
    }
}
