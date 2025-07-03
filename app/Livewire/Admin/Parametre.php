<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Filament\Notifications\Notification;

class Parametre extends Component
{
    use WithFileUploads;

    // Propriétés du modèle
    public $settings;
    
    // Informations générales
    public $name;
    public $slogan;
    public $description;
    
    // Design
    public $logo;
    public $primary_color;
    public $secondary_color;
    public $accent_color;
    
    // Menu
    public $menu_pdf;
    public $menu_link;
    public $special_offers;
    
    // Réseaux sociaux
    public $facebook_url;
    public $instagram_url;
    public $twitter_url;
    public $tiktok_url;
    public $snapchat_url;
    
    // Contact
    public $phone;
    public $email;
    public $address;
    public $maps_link;
    public array $facebookVideos = [];

    
    // Livraison
    public $delivery_zone;
    public $delivery_apps;
    
    // Interface
    public $activeTab = 'general';
    public $isLoading = false;
    public $message = '';
    public $messageType = 'success';

    protected $rules = [
        'name' => 'required|string|max:255',
        'slogan' => 'nullable|string|max:500',
        'description' => 'nullable|string|max:2000',
        'primary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        'secondary_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        'accent_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        'logo' => 'nullable|image|max:2048',
        'menu_pdf' => 'nullable|file|mimes:pdf|max:5120',
        'menu_link' => 'nullable|url',
        'special_offers' => 'nullable|string|max:1000',
        'facebook_url' => 'nullable|url',
        'instagram_url' => 'nullable|url',
        'twitter_url' => 'nullable|url',
        'tiktok_url' => 'nullable|url',
        'snapchat_url' => 'nullable|url',
        'phone' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'address' => 'nullable|string|max:500',
        'maps_link' => 'nullable|url',
        'delivery_zone' => 'nullable|string|max:255',
        'delivery_apps' => 'nullable|string|max:500',
        'facebookVideos' => 'nullable|array',
        
    ];

    public function mount()
    {
        $this->settings = Setting::getInstance();
        $this->loadSettings();
    }

    public function loadSettings()
    {
        $this->name = $this->settings->name;
        $this->slogan = $this->settings->slogan;
        $this->description = $this->settings->description;
        $this->primary_color = $this->settings->primary_color;
        $this->secondary_color = $this->settings->secondary_color;
        $this->accent_color = $this->settings->accent_color;
        $this->menu_link = $this->settings->menu_link;
        $this->special_offers = $this->settings->special_offers;
        $this->facebook_url = $this->settings->facebook_url;
        $this->instagram_url = $this->settings->instagram_url;
        $this->twitter_url = $this->settings->twitter_url;
        $this->tiktok_url = $this->settings->tiktok_url;
        $this->snapchat_url = $this->settings->snapchat_url;
        $this->phone = $this->settings->phone;
        $this->email = $this->settings->email;
        $this->address = $this->settings->address;
        $this->maps_link = $this->settings->maps_link;
        $this->delivery_zone = $this->settings->delivery_zone;
        $this->delivery_apps = $this->settings->delivery_apps;
        $this->facebookVideos = $this->settings->facebookVideos ?? [];
    }

    public function saveSettings()
    {
        $this->isLoading = true;
        $this->message = '';

        $this->validate();

        // Upload du logo si présent
        if ($this->logo) {
            $logoname = 'logoAuth.' . $this->logo->getClientOriginalExtension();
            $logoPath = $this->logo->storeAs('restaurant/logo', $logoname, 'public');

            $this->settings->updateFile('logo_path', $logoPath);
        }
        
        // Upload du menu PDF si présent
        if ($this->menu_pdf) {
            $menuname = 'menuAuth.' . $this->menu_pdf->getClientOriginalExtension();
            $menuPath = $this->menu_pdf->storeAs('restaurant/menu', $menuname, 'public');
            $this->settings->updateFile('menu_pdf_path', $menuPath);
        }

        // Mise à jour des autres champs
        $this->settings->update([
            'name' => $this->name,
            'slogan' => $this->slogan,
            'description' => $this->description,
            'primary_color' => $this->primary_color,
            'secondary_color' => $this->secondary_color,
            'accent_color' => $this->accent_color,
            'menu_link' => $this->menu_link,
            'special_offers' => $this->special_offers,
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'twitter_url' => $this->twitter_url,
            'tiktok_url' => $this->tiktok_url,
            'snapchat_url' => $this->snapchat_url,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'maps_link' => $this->maps_link,
            'delivery_zone' => $this->delivery_zone,
            'delivery_apps' => $this->delivery_apps,
            'facebookVideos' => array_filter($this->facebookVideos),
        ]);

        // $this->message = 'Paramètres enregistrés avec succès !';
        // $this->messageType = 'success';

        Notification::make('message')
                        ->title('Paramètres modifiés avec succès !')
                        ->success()
                        ->send();

        // Reset des fichiers temporaires
        $this->logo = null;
        $this->menu_pdf = null;


    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function removeLogo()
    {
        if ($this->settings->logo_path && Storage::disk('public')->exists($this->settings->logo_path)) {
            Storage::disk('public')->delete($this->settings->logo_path);
            $this->settings->update(['logo_path' => null]);
            // $this->message = 'Logo supprimé avec succès.';
            // $this->messageType = 'success';

            Notification::make('message')
                        ->title('Logo supprimé avec succès !')
                        ->success()
                        ->send();
        }
    }

    public function removeMenuPdf()
    {
        if ($this->settings->menu_pdf_path && Storage::disk('public')->exists($this->settings->menu_pdf_path)) {
            Storage::disk('public')->delete($this->settings->menu_pdf_path);
            $this->settings->update(['menu_pdf_path' => null]);
            $this->message = 'Menu PDF supprimé avec succès.';
            $this->messageType = 'success';
        }
    }

    public function clearMessage()
    {
        $this->message = '';
    }
    
    public function render()
    {
        return view('livewire.admin.parametre');
    }
}
