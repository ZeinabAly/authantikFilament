<?php

namespace App\Models;

use App\Models\Employee;
use App\Models\Pointage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendrierPresence extends Model
{
    use softDeletes;
    protected $guarded = ['id'];

    public function employees(){
        return $this->hasMany(Employee::class);
    }

    public function pointages(){
        return $this->hasMany(Pointage::class);
    }
}
