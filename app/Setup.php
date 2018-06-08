<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $fillable = [
        'title_image',
        'modules',
        'views',
    ];
}
