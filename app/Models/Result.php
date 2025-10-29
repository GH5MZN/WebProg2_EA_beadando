<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'race_date',
        'pilot_id',
        'position',
        'issue',
        'team',
        'car_type',
        'engine'
    ];

    protected $casts = [
        'race_date' => 'date'
    ];

    public function pilot()
    {
        return $this->belongsTo(Pilot::class, 'pilot_id', 'pilot_id');
    }
}
