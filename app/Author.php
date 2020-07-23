<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = ['name', 'dob'];

    protected $dates = [
        'dob'
    ];

    public function setDobAttribute($attribute)
    {
        $this->attributes['dob'] = Carbon::parse($attribute);
    }
}
