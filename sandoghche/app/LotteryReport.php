<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LotteryReport extends Model
{
    protected $fillable = ['user_id','title','description','lottery_id'];
    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
