<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('cart_value', 'like', "%{$value}%")
            ->orWhere('value', 'like', "%{$value}%");
    }
    
    protected $casts = [
        'cart_value' => 'float',
        'value' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($coupon) {
            // Génère le code uniquement s'il n'est pas déjà défini
            if (empty($coupon->code)) {
                $coupon->code = self::generateCouponCode($coupon->expiry_date, $coupon->value);
            }
        });
    }
    
    private static function generateCouponCode($expiryDate, $value)
    {
        $datePart = Carbon::parse($expiryDate)->format('ymd');
        $valuePart = intval($value);
        $randomPart = strtoupper(Str::random(3));

        return "C{$datePart}{$valuePart}{$randomPart}";
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'code';
    }
}
