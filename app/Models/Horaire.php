<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Horaire extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
    
    
    // Obtenir l'ID du service actuel basé sur l'heure
     
    public static function getCurrentShiftId()
    {
        $now = now()->format('H:i:s');
        
        return self::whereTime('start_time', '<=', $now)
            ->whereTime('end_time', '>=', $now)
            ->first()
            ->id ?? 1; // return le shift actuel
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
