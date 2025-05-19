<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SousCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Category extends Model
{
    use softDeletes, HasSlug;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%");
    }

    public function sous_categories(){
        return $this->hasMany(SousCategory::class);
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
