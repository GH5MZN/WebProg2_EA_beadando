<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PilotCurrent extends Model
{
    protected $table = 'pilotsCurrent';
    
    protected $primaryKey = 'pilot_id';
    
    protected $fillable = [
        'pilot_id',
        'name',
        'gender',
        'nationality',
        'team'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'pilot_id', 'pilot_id');
    }
}