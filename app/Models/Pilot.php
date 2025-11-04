<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $fillable = [
        'pilot_id',
        'name',
        'gender',
        'birth_date',
        'nationality',
        'team'
    ];

    protected $casts = [
        'birth_date' => 'date'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'pilot_id', 'pilot_id');
    }
}
