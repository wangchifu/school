<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setup extends Model
{
    protected $fillable = [
        'nav_color',
        'title_image',
        'modules',
        'views',
    ];
}
