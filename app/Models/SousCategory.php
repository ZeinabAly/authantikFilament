<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Category, Product};
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class SousCategory extends Model
{
    use softDeletes, HasSlug;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%");
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function products(){
        return $this->hasMany(Product::class, 'sousCategory_id');
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
}
