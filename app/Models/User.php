<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\{Permission, Role};
use App\Models\{Employee, Reservation, Address, User};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, softDeletes;

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

    // protected static function booted()
    // {
    //     // DONNER TOUTES LES PERMISSIONS AU PREMIER USER
    //     $role = Role::firstOrCreate(['name' => 'SuperAdmin', 'guard_name' => 'web']);
    //     $permissions = Permission::all();
    //     // $role->syncPermissions($permissions);
    //     foreach ($permissions as $permission) {
    //         $role->givePermissionTo($permission);
    //     }

    //     $user = User::find(1);
    //     $user->assignRole('SuperAdmin');

    //     static::created(function ($user) {
    //         if (!$user->hasRole('user')) {
    //             $user->assignRole('user');
    //         }
    //     });

    //     // FAIRE DE SORTE QUE CHAQUE USER AIE LE ROLE USER
    //     $users = User::all();
    //     $roleUser = Role::firstOrCreate(['name' => 'User', 'guard_name' => 'web']);

    //     foreach ($users as $user) {
    //         if($user && !$user->hasAnyRole(['SuperAdmin', 'Admin', 'Manager', 'Caissier', 'User'])){
    //             $user->assignRole($roleUser);
    //         }
    //     }
    // }

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

    public function contacts(){
        return $this->hasMany(Contact::class);
    }

    // METHODE HASROLE
    // public function hasRole($role){
    //     return $this->roles->contains('name', $role);
    // }  

    // // Pour plusieurs roles
    // public function hasAnyRole(array $roles)
    // {
    //     foreach ($roles as $role) {
    //         if ($this->hasRole($role)) {
    //             return true;
    //         }
    //     }
    //     return false;
    // }

    public function adresses(){
        return $this->hasMany(Address::class);
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'name';
    }
}
