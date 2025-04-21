<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SousCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    public function scopeSearch($query, $value){
        $query->where('name', 'like', "%{$value}%")
            ->orWhere('description', 'like', "%{$value}%");
    }

    public function sous_categories(){
        return $this->hasMany(SousCategory::class);
    }
}
