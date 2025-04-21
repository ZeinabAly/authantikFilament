<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Address extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->where('commune', 'like', "%{$value}%")
            ->where('quartier', 'like', "%{$value}%")
            ->where('phone', 'like', "%{$value}%")
            ->where('address', 'like', "%{$value}%");
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
