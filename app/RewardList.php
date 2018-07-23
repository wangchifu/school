<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RewardList extends Model
{
    protected $fillable = [
        'order_by',
        'title',
        'description',
        'reward_id',
    ];
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
    public function winners()
    {
        return $this->hasMany(Winner::class);
    }
}