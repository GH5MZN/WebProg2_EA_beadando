<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable = [
        'race_date',
        'pilotaaz',
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
        return $this->belongsTo(Pilot::class, 'pilotaaz', 'az');
    }

    public function grandPrix()
    {
        return $this->belongsTo(GrandPrix::class, 'race_date', 'race_date');
    }
}
