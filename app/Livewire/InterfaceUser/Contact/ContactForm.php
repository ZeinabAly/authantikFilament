<?php

namespace App\Livewire\InterfaceUser\Contact;

use App\Models\Contact;
use Livewire\Component;
use App\Jobs\ContactNotificationJob;
use Illuminate\Support\Facades\Auth;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $phone;
    public $message;

    protected function rules() 
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'email',
            'phone' => 'required|integer|digits:9',
            'message' => 'min:10',
        ];
    }

    protected function messages(){
        return [
            'name.required' => 'Ce champ est obligatoire', 
            'name.string' => 'Le nom doit être une chaine de caractères', 
            'name.max' => 'Le nom ne doit pas dépasser 255 caractères', 
            'email.email' => 'Veuillez respecter le format email@gmail.com', 
            'phone.required' => 'Ce champ est obligatoire', 
            'phone.digits' => 'Le numéro de téléphone comporte 9 chiffres',
            'message.min' => 'Le message doit contenir un minimum de 10 caractères', 
        ];
    }

    public function submit()
    {
        if(!auth()->check()){
            return session()->flash('error', 'Vous devez être connecté !');
        }
        $this->validate();

        // Sauvegarde dans la base (si tu as un modèle Contact)
        $contact = Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'message' => $this->message,
        ]);

        // Réinitialiser les champs
        $this->reset();

        
        // $contact = Contact::find(1);
        ContactNotificationJob::dispatch($contact, Auth::user())->delay(now()->addSeconds(1));

        // Message flash ou notification
        return session()->flash('success', 'Votre message a bien été envoyé !');
    }

    public function render()
    {
        return view('livewire.interface-user.contact.contact-form');
    }
}
