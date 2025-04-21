<?php

namespace App\Models;

use App\Models\{Employee, Horaire};
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendrierEmployee extends Model
{
    use softDeletes;
    protected $guarded = ['id']; 

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    
    public function horaire()
    {
        return $this->belongsTo(Horaire::class);
    }
}
