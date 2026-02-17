<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category, Product, Contact, SousCategory, Employee, Slider, Setting};
use App\Jobs\ContactNotificationJob;
use Filament\Notifications\Notification;

class HomeController extends Controller
{
    public function index(){

        // Menu du jour
        $products = Product::where('platDuJour', 1)->take(8)->get();
        if($products->count() < 8){
            $products = Product::where('featured', true)->take(8)->get();
        }
        $categories = Category::get(); 
        $sousCategories = SousCategory::get(); 
        // Récupérer les featured et en prendre 8 au hasard en PHP
        $slideProducts = Product::where('featured', true)->get()->shuffle()->take(8);

        $employees = Employee::get(); 

        $sliders = Slider::where('page', 'index')->where('position', 'Banniere')->get(); 

        $settings = Setting::first(); 

        return view('index', compact('products','categories', 'sousCategories','slideProducts','employees', 'sliders', 'settings'));
    
    }

    public function contact(){
        $settings = Setting::first(); 
        return view('pagesInterfaceFront.contact', compact('settings'));
    }


    public function menu(){
        $products = Product::all();
        return view('pagesInterfaceFront.menu', compact('products'));
    }

    public function about(){
        $products = Product::paginate(12);
        $employees = Employee::get(); 
        return view('pagesInterfaceFront.about', compact('products', 'employees'));
    }

    public function reservation(){
        return view('pagesInterfaceFront.reservation');
    }


    public function viewProduct(Product $product){
        $relatedProducts = Product::where('sousCategory_id', '<>', $product->sousCategory)->get();
        return view('pagesInterfaceFront.product.view', compact('product', 'relatedProducts'));
    }

    public function buyNow(Product $product){ 
        return view('pagesInterfaceFront.order.buyNow', compact('product'));
    }


}
