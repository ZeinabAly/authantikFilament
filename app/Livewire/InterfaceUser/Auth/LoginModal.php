<?php

namespace App\Livewire\InterfaceUser\Auth;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

#[On('userLogged')]
class LoginModal extends Component
{
    public $email;
    public $password;

    protected function rules(){
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ];
    }

    protected function messages()
    {
        return [
            'email.required' => 'Ce champ est obligatoire',
            'email.string' => 'L\'email doit être une chaîne de caractères',
            'email.email' => 'L\'email doit être de type exemple@gmail.com',
            'password.required' => 'Ce champ est obligatoire',
        ];
    }

    public function login()
    {
    
        $this->validate();

        $users = User::get();
        foreach ($users as $user) {
            if($user->email == $this->email && Hash::make($this->password)){
                Auth::login($user);

                $this->dispatch('userLogged');
                $this->reset(['email', 'password']);
                return session()->flash('success', 'Vous êtes connectés ! ');
            }
        }

    }

    public function render()
    {
        return view('livewire.interface-user.auth.login-modal');
    }
}
