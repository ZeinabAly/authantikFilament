<?php

namespace App\Livewire\Client;

use Livewire\Component;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Filament\Notifications\Notification;

class MonCompteManager extends Component
{
    public $user;
    public $name = '';
    public $email = '';
    public $phone = '';

    // Modifier le mot de passe
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    // Supprimer compte
    // public $password;
    public $confirmingUserDeletion = false;
    
    public function mount(){
    
        $this->user = auth()->user();
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->phone = $this->user->phone;
    }
    
    public function updateInformations(){
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
        ]);

        $this->user->name = $this->name;
        if ($this->email !== $this->user->email) {
            $this->user->email = $this->email;
            $this->user->email_verified_at = null;
        }
        
        if($this->phone !== ""){
            $this->user->phone = $this->phone;
        }

        $this->user->save();

        Notification::make()
            ->title('Informations modifiées avec succès ! ')
            ->success()
            ->body('Vos informations ont été modifiées')
            ->send();
    }

    public function updatePassword(){
        $this->resetErrorBag();

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'required', 'string', 'min:8'],
        ]);

        $user = auth()->user();
        $user->password = Hash::make($this->password);
        $user->save();

        Notification::make()
            ->title('Mot de passe modifié avec succès ! ')
            ->success()
            ->body('Votre mot de passe a été modifié')
            ->send();

        // Reset the form
        $this->reset(['current_password', 'password', 'password_confirmation']);
    }

    public function destroyAccount(){

        $this->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = auth()->user();

        Auth::logout();


        $user->delete();

        session()->invalidate();
        session()->regenerateToken();

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.client.mon-compte-manager');
    }
}
