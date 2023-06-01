<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $fillable = ['lottery_id','phone_number'];
    public function lottery()
    {
        return $this->belongsTo('App\Lottery');
    }


}
