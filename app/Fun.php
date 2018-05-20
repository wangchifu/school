<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fun extends Model
{
    protected $fillable = [
        'type',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
