<?php

namespace App\Models;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Absence extends Model
{
    use softDeletes;
    protected $guarded = ['id']; 

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
