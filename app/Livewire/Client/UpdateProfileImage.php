<?php

namespace App\Livewire\Client;

use Carbon\Carbon;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\File;
use Filament\Notifications\Notification;
// use App\Services\ImageStockageService;

class UpdateProfileImage extends Component
{
    use WithFileUploads;

    public $photo;
    public $user;

    public function mount(User $user)
    {
        $this->user = $user;
    }

    protected function rules()
    {
        return [
            'photo' => ['nullable', 'mimes:png,jpeg,webp,jpg']
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->photo) {
            // Suppression de l’ancienne image si elle existe
            $imagePath = $this->user->image;

            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }

            // ENREGISTREMENT DES IMAGES
            $timestamp = now()->timestamp;
            $extension = $this->photo->getClientOriginalExtension();
            $fileName = "{$timestamp}.{$extension}";
            $filePath = "uploads/users/{$fileName}";
        
            // Stocker le fichier dans storage/app/public/uploads/users/
            $this->photo->storeAs('uploads/users', $fileName, 'public');
        
            // Enregistrer le chemin dans la base de données
            $this->user->image = $filePath;
            $this->user->save();

            // Réinitialisation du champ photo
            $this->photo = null;

            // Message de succès
            $this->dispatch('refresh');
            return Notification::make()
                    ->title('Photo de profil mise à jour avec succès')
                    ->success()
                    ->body('Votre photo a été modifiée')
                    ->send();
        }
        else{
            return ;
        }
    }

    public function render()
    {
        return view('livewire.client.update-profile-image');
    }
}
