<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\{Employee, Reservation, Address};
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */

    protected static function booted()
    {
        static::created(function ($user) {
            if (!$user->hasRole('user')) {
                $user->assignRole('user');
            }
        });
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    public function reservations(){
        return $this->hasMany(Reservation::class);
    }

    // public function contacts(){
    //     return $this->hasMany(Contact::class);
    // }

    // METHODE HASROLE
    public function hasRole($role){
        return $this->roles->contains('name', $role);
    }  

    // Pour plusieurs roles
    public function hasAnyRole(array $roles)
    {
        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }
        return false;
    }

    public function adresses(){
        return $this->hasMany(Address::class);
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
