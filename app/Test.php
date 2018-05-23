<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $fillable = [
        'disable',
        'name',
        'do',
        'user_id',
        'unpublished_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
