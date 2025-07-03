<?php

namespace App\Livewire\InterfaceUser\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\{Auth, Hash};

#[On('userLogged')]
class RegisterModal extends Component
{
    public $name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;

    protected function rules(){
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'phone' => ['required', 'numeric', 'digits:9', 'unique:users,phone'],
            'password' => ['required', 'min:6', 'confirmed',],
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'Ce champ est obligatoire',
            'email.string' => 'L\'email doit être une chaîne de caractères',
            'email.email' => 'L\'email doit être de type exemple@gmail.com',
            'email.unique' => 'Cet email existe',
            'name.required' => 'Ce champ est obligatoire',
            'phone.required' => 'Ce champ est obligatoire',
            'phone.numeric' => 'Le numero de téléphone ne doit comporter que des chiffres',
            'phone.digits' => 'Le numero de téléphone ne doit comporter 9 chiffres',
            'phone.unique' => 'Ce numéro existe',
            'password.required' => 'Ce champ est obligatoire',
            'password.min' => 'Saisissez un mot de passe plus fort',
            'password.confirmed' => 'Les mots de passe doivent être identiques',
        ];
    }

    public function register()
    {
    
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        Auth::login($user);
        
        $this->reset(['name', 'email', 'phone', 'password', 'password_confirmation']);

        $this->dispatch('userLogged');

        // $this->refresh();
        
        return session()->flash('success', 'Vous êtes connectés ! ');
    }

    public function render()
    {
        return view('livewire.interface-user.auth.register-modal');
    }
}
