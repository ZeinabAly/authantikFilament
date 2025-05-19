<?php

namespace App\Http\Controllers\FrontOffice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Category, Product, Contact, SousCategory};
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
        $slideProducts = Product::take(8)->inRandomOrder()->get();

        return view('index', compact('products','categories', 'sousCategories','slideProducts'));
    
    }

    public function contact(){
        return view('pagesInterfaceFront.contact');
    }

    public function contact_store(Request $request){

        $contactInfos = Contact::find(3);
        ContactNotificationJob::dispatch($contactInfos, auth()->user())->delay(now()->addSeconds(1));
        // dd('envoyé');
        
        if(!auth()->user()){
            return redirect()->route('login');
        }else{
            $request->validate([
                'name' => 'required|max:100',
                'email' => 'required|email',
                'phone' => 'required|numeric|digits:9',
                'message' => 'required',
            ]);

            $data = [
                'user_id' => auth()->id(),
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'message' => $request->message
            ];
            
            // $contactInfos = Contact::create($data);

            $contactInfos = Contact::find(3);

            ContactNotificationJob::dispatch($contactInfos, auth()->user())->delay(now()->addSeconds(1));
            
            return redirect()->route('home.contact')->with('status', 'Message envoyé avec succès ! ');
        }
        
    }

    public function menu(){
        $products = Product::all();
        return view('pagesInterfaceFront.menu', compact('products'));
    }

    public function about(){
        $products = Product::paginate(12);
        return view('pagesInterfaceFront.about', compact('products'));
    }

    // public function reservation(){
    //     return view('pagesInterfaceFront.reservation');
    // }

    // public function createReservation(Request $request){
    //     if(!auth()->check()){
    //         return redirect()->back()->with('loginExige', 'Veuillez vous contacter !');
    //     }
    
    //     // Valider et stocker la réservation
    //     $request->validate([
    //         'client_name' => 'required|string',
    //         'date' => 'required|date',
    //         'heure' => 'required',
    //         'nbrPers' => 'required|integer|min:1',
    //         'phone' => 'required|digits:9',
    //     ]);

    //     $data = [
    //         'name' => $request->name,
    //         'date'=> $request->date,
    //         'heure'=> $request->heure,
    //         'phone'=> $request->phone,
    //         'nbrPers'=> $request->nbrPers,
    //     ];

    //     if($request->email){
    //         $data['email'] =  $request->email ;
    //     }
    //     if($request->details){
    //         $data['details'] =  $request->details ;
    //     }
    
    //     dd($data);
    //     $reservation = auth()->user()->reservations()->create($data);
    

    //     $reservationDetails = [
    //         'id' => $reservation->id,
    //         'client_name' => $reservation->name,
    //         'date' => $reservation->date,
    //         'heure' => $reservation->heure,
    //         'nbrPers' => $reservation->nbrPers ?? 1,
    //     ];

    //     SendRerservationNotificationJob::dispatch($reservationDetails, auth()->user())->delay(now()->addSeconds(1));
    // }

    public function viewProduct(Product $product){
        $relatedProducts = Product::where('sousCategory_id', '<>', $product->sousCategory)->get();
        return view('pagesInterfaceFront.product.view', compact('product', 'relatedProducts'));
    }

    public function buyNow(Product $product){ 
        return view('pagesInterfaceFront.order.buyNow', compact('product'));
    }


}
