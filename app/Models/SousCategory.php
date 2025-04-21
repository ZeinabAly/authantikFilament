<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\{Category, Product};

class SousCategory extends Model
{
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
}
