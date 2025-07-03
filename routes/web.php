<?php

use App\Models\{Order, RapportJournalier};
use App\Services\{FacturePDFService, RapportGenerateService};
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FrontOffice\CartController;
use App\Http\Controllers\FrontOffice\HomeController;
use App\Http\Controllers\FrontOffice\ReservationController;

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Telechargement de la facture
Route::get('/facture/{order}/telecharger', function(Order $order, FacturePDFService $service) {
    // Sauvegarder d'abord le fichier sur le serveur
    // $service->saveInvoiceToFile($order);
    
    // Puis générer un nouveau PDF pour le téléchargement
    $pdf = $service->generateInvoice($order);
    return $pdf[0]->download('facture-commande-'.$order->id.'.pdf');
})->name('facture.telecharger');

Route::get('/recu/{order}/telecharger', function(Order $order, FacturePDFService $service) {
    // Sauvegarder d'abord le fichier sur le serveur
    // $service->saveInvoiceToFile($order);
    
    // Puis générer un nouveau PDF pour le téléchargement
    $pdf = $service->generateInvoice($order);
    return $pdf[1]->download('recu_cuisine-'.$order->id.'.pdf');;
})->name('recu.telecharger');


Route::get('/rapport/{rapport}/telecharger', function(RapportJournalier $rapport, RapportGenerateService $service) {
    // Puis générer un nouveau PDF pour le téléchargement
    return $service->rapportJournalier($rapport);
})->name('rapport.telecharger');



Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('index');
// })->middleware(['auth', 'verified'])->name('dashboard');

// LES ROUTES DU FRONT OFFICE

Route::get('/menu', [HomeController::class, 'menu'])->name('home.menu');
Route::get('/about', [HomeController::class, 'about'])->name('home.about');
Route::get('/reservation', [HomeController::class, 'reservation'])->name('home.reservation');

// Reservation
// Route::resource('/reservation', ReservationController::class)->except('index');
// Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::post('/contact/store', [HomeController::class, 'contact_store'])->name('home.contact.store');
Route::get('/product/{product}', [HomeController::class, 'viewProduct'])->name('product.view');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
// Ici on utilse pas le controller pour envoyer la vue mais le compsant livewire
Route::get('/order-confirmation/{order}', [CartController::class, 'orderConfirmation'])->name('cart.order.confirmation');
Route::get('/wishlist', [CartController::class, 'wishlist'])->name('cart.wishlist');

// ACHETER UN PRODUIT MAINTENANT
Route::get('/acheter/{product}', [HomeController::class, 'buyNow'])->name('buy.now');

// IL FAUT ETRE CONNECTE A L'APPLI POUR ALLER SUR LE DASHBOARD
Route::get('/admin', function () {
    if (!auth()->check()) {
        return redirect()->route('login')
            ->with('message', 'Connectez-vous d\'abord');
    }else{
        if(auth()->user()->hasAnyRole(['super_admin' ,'Admin', 'Manager', 'Caissier'])){
            return redirect('/admin/login');
        // if(auth()->user()->hasAnyRole(['SuperAdmin' ,'Admin', 'Manager', 'Caissier'])){
            auth()->logout();
        }else{
            return redirect('/client/login');
        }
    }
});

require __DIR__.'/auth.php';
