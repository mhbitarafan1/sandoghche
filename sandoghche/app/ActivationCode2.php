<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ActivationCode2 extends Model
{
    use Notifiable;
    protected $fillable = ['phone_number','code','expire_at'];
}
