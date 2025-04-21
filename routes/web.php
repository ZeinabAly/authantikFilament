<?php

use App\Models\Order;
use App\Services\FacturePDFService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Telechargement de la facture
Route::get('/facture/{order}/telecharger', function(Order $order, FacturePDFService $service) {
    // Sauvegarder d'abord le fichier sur le serveur
    $service->saveInvoiceToFile($order);
    
    // Puis générer un nouveau PDF pour le téléchargement
    $pdf = $service->generateInvoice($order);
    return $pdf[0]->download('facture-commande-'.$order->id.'.pdf');
})->name('facture.telecharger');

Route::get('/recu/{order}/telecharger', function(Order $order, FacturePDFService $service) {
    // Sauvegarder d'abord le fichier sur le serveur
    $service->saveInvoiceToFile($order);
    
    // Puis générer un nouveau PDF pour le téléchargement
    $pdf = $service->generateInvoice($order);
    return $pdf[1]->download('recu_cuisine-'.$order->id.'.pdf');;
})->name('recu.telecharger');


require __DIR__.'/auth.php';
