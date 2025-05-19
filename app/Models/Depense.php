<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Depense extends Model
{
    use softDeletes;
    protected $guarded = ['id']; 

    // Pour avoir le slug a la place de l'id dans l'url
    public function getRouteKeyName(): string
    {
        return 'description';
    }
}
