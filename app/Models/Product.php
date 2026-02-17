<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Variante, Accompagnement, Supplement, SousCategory, OrderItem};
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Product extends Model
{
    use softDeletes, HasSlug;

    protected $guarded = ['id'];

    // public function scopeSearch($query, $value){
    //     $query->where('name', 'like', "%{$value}%")
    //         ->orWhere('description', 'like', "%{$value}%");
    // }

    protected $casts = [
        'sale_price' => 'double',
        'regular_price' => 'double',
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


    // GENERATEUR DE SLUG
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // Formatage des prix
    public function getPrixFormatAttribute(): string
    {
        return number_format($this->final_price, 0, ',', '.') . ' GNF';
    }
}
