<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = [
        'name',
        'fun',
        'type',
        'folder_id',
        'job_title',
        'order_by',
    ];
}
