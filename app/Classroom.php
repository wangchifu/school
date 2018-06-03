<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'disable',
        'name',
        'close_sections',
    ];
    public function classroom_orders()
    {
        return $this->hasMany(ClassroomOrder::class);
    }
}
