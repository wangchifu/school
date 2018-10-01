<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OriSub extends Model
{
    protected $fillable = [
        'semester',
        'ori_teacher',
        'sub_teacher',
        'type',
        'sections',
        'section',
        'ps'
    ];
}
