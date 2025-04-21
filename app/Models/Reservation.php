<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Carbon\Carbon;

class Reservation extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'date' => 'date',
    ];

    
    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('phone', 'like', "%{$value}%")
            ->orWhere('email', 'like', "%{$value}%");
    }

    
    public function user(){
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();
        
        // Exécuter cette mise à jour au démarrage du modèle
        static::updateExpiredReservationStatus();
    }

    public static function updateExpiredReservationStatus()
    {
        // D'abord, mettre à jour toutes les commandes sur place expirées
        self::where('date', '<', Carbon::today())
            ->update(['status' => "passee"]);
        
        // Ensuite retourner une nouvelle requête pour chaîner d'autres opérations
        return self::query();
    }

}
