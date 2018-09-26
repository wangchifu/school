<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubstituteTeacher extends Model
{
    protected $fillable = [
        'teacher_name',
        'ps',
        'active',
    ];
}
