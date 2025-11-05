<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrandPrix extends Model
{
    protected $table = 'grand_prix';

    protected $fillable = [
        'race_date',
        'name',
        'location'
    ];

    protected $casts = [
        'race_date' => 'date'
    ];

    public function results()
    {
        return $this->hasMany(Result::class, 'grand_prix_id');
    }
}
