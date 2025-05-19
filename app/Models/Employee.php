<?php

namespace App\Models;

use App\Models\{CalendrierPresence, Pointage, Absence, CalendrierEmployee, Order, Reservation};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use softDeletes;
    protected $guarded = ['id']; 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendrier_presences()
    {
        return $this->hasMany(CalendrierPresence::class);
    }

    public function calendrier_employees()
    {
        return $this->hasMany(CalendrierEmployee::class);
    }

    public function pointages()
    {
        return $this->hasMany(Pointage::class);
    }

    public function absences()
    {
        return $this->hasMany(Absence::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'employee_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_id', 'user_id');
    }

    protected function casts(): array
    {
        return [
            'embauche_at' => 'datetime',
            'fin_contrat' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
