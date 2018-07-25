<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    protected $fillable = [
        'reward_list_id',
        'reward_id',
        'user_id',
        'year_class',
        'student_id',
        'name',
    ];
    public function reward_list()
    {
        return $this->belongsTo(RewardList::class);
    }
    public function reward()
    {
        return $this->belongsTo(Reward::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
