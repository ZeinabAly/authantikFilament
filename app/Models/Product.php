<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Variante, Accompagnement, Supplement, SousCategory, OrderItem};
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%");
    }

    protected $casts = [
        'sale_price' => 'integer',
        'regular_price' => 'integer',
        'images' => 'array',
        'featured' => 'boolean', 
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function sousCategory()
    {
        return $this->belongsTo(SousCategory::class,'sousCategory_id');
    }

    public function variantes()
    {
        // return $this->belongsToMany(Variante::class, 'product_variante')->withPivot('price')->withTimestamps();
        return $this->belongsToMany(Variante::class, 'product_variante')->withTimestamps();
    }

    public function accompagnements()
    {
        return $this->belongsToMany(Accompagnement::class, 'product_accompagnement')->withTimestamps();
    }

    public function supplements()
    {
        return $this->belongsToMany(Supplement::class, 'product_supplement')->withTimestamps();
    }

}
