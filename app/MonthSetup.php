<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MonthSetup extends Model
{
    protected $fillable = [
        'semester',
        'type',
        'event_date',
        'another_date',
    ];
}
