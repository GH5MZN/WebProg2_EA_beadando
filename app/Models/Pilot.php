<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pilot extends Model
{
    protected $primaryKey = 'az';
    
    protected $fillable = [
        'az',
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
        return $this->hasMany(Result::class, 'pilotaaz', 'az');
    }
}
