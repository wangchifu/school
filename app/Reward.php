<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $fillable = [
        'disable',
        'name',
        'description',
        'user_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reward_lists()
    {
        return $this->hasMany(RewardList::class);
    }
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}
