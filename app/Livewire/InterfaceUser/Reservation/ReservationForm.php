<?php

namespace App\Livewire\InterfaceUser\Reservation;

use Livewire\Component;
use App\Models\Reservation;

class ReservationForm extends Component
{
    public $nbrPers;
    public $date;
    public $heure;
    public $name;
    public $phone;
    public $email;
    public $details;

    protected $rules = [
        'nbrPers' => 'required|integer|min:1|max:50',
        'date' => 'required|date|after_or_equal:today',
        'heure' => 'required',
        'name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        // 'email' => 'email',
    ];

    protected function messages() 
    {
        return [
            'name.required' => 'Ce champ est obligatoire',
            'name.string' => 'Le nom doit être une chaine de caractère',
            'date.required' => 'Ce champ est obligatoire',
            'date.after_or_equal' => 'Vous ne pouvez pas choisir une date passée',
            'heure.required' => 'Ce champ est obligatoire',
            'nbrPers.required' => 'Ce champ est obligatoire',
            'phone.required' => 'Ce champ est obligatoire',
            'email.email' => 'L\'email doit être de type email',
        ];
    }

    public function submit()
    {
        if(!auth()->check()){
            return session()->flash('loginExige', 'Vous devez être connecté pour effectuer une réservation !');
        } 
        $this->validate();

        Reservation::create([
            'user_id' => auth()->id(),
            'nbrPers' => $this->nbrPers,
            'date' => $this->date,
            'heure' => $this->heure,
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'details' => $this->details,
        ]);

        $this->reset();

        session()->flash('success', 'Votre réservation a bien été enregistrée !');
    }

    public function render()
    {
        return view('livewire.interface-user.reservation.reservation-form');
    }
}
