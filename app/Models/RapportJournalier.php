<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RapportJournalier extends Model
{
    use softDeletes;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'date';
    }
}
