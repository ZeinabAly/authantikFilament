<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Order;

class Transaction extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('mode_payement', 'like', "%{$value}%")
            ->orWhere('status', 'like', "%{$value}%");
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
