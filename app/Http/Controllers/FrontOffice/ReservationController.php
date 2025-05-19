<?php

namespace App\Http\Controllers\FrontOffice;

use Illuminate\Http\Request;
use App\Models\{Reservation, User};
use App\Http\Controllers\Controller;
use App\Jobs\SendReservationNotificationJob;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ReservationNotification;

class ReservationController extends Controller
{
    public function index(){
        // return view('pagesInterfaceFront.reservation');
    }

    public function create(){
        return view('pagesInterfaceFront.reservation');
    }
    public function show(){
        // return view('pagesInterfaceFront.reservation');
    }

    public function store(Request $request){

        if(!auth()->check()){
            return redirect()->back()->with('loginExige', 'Vous devez être connecté pour faire une réservation !');
        }
    
        // Valider et stocker la réservation
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required',
            'nbrPers' => 'required|integer|min:1',
            'phone' => 'required|digits:9',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'date'=> $request->date,
            'heure'=> $request->heure,
            'phone'=> $request->phone,
            'nbrPers'=> $request->nbrPers,
        ];

        if($request->email){
            $data['email'] =  $request->email ;
        }
        if($request->details){
            $data['details'] =  $request->details ;
        }

        
        $reservation = Reservation::create($data);
        
        // $reservation = Reservation::find(4);
        
        SendReservationNotificationJob::dispatch($reservation, auth()->user())->delay(now()->addSeconds(1));
        
        return redirect()->back()->with('success', 'Réservation effectuée avec succès !');
    }


    public function update(Reservation $reservation, Request $request){
        if(!auth()->check()){
            return redirect()->back()->with('loginExige', 'Vous devez être connecté pour faire une réservation !');
        }
    
        // Valider et stocker la réservation
        $request->validate([
            'name' => 'required|string',
            'date' => 'required|date',
            'heure' => 'required',
            'nbrPers' => 'required|integer|min:1',
            'phone' => 'required|digits:9',
        ]);

        $data = [
            'user_id' => auth()->id(),
            'name' => $request->name,
            'date'=> $request->date,
            'heure'=> $request->heure,
            'phone'=> $request->phone,
            'nbrPers'=> $request->nbrPers,
        ];

        if($request->email){
            $data['email'] =  $request->email ;
        }
        if($request->details){
            $data['details'] =  $request->details ;
        }
    
        // $reservation = Reservation::create($data);

        $reservation->update($data);

        SendReservationNotificationJob::dispatch($reservation, auth()->user())->delay(now()->addSeconds(1));
        
        return redirect()->back()->with('success', 'Réservation modifiée avec succès !');
    }
    
    public function destroy(Reservation $reservation){
        $reservation->delete();
        return redirect()->back()->with('success', 'Réservation supprimée avec succès !');
    }
}
