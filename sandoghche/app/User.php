<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone_number', 'password','avatar_url','cash',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function activationcodes()
    {
        return $this->hasMany('App\ActivationCode');
    }
     public function lotterymanager()
    {
        return $this->hasOne('App\LotteryManager');
    }
     public function lotterymember()
    {
        return $this->hasOne('App\LotteryMember');
    }
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    public function roles()
    {
        return $this->belongsToMany('App\Role');
    }
    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
    public function lotteryreports ()
    {
        return $this->hasMany('App\LotteryReport');
    }
    public function calculatePoints()
    {
        //calculate point of time of membering
        $now = Carbon::now();
        $timeOfCreateUser = $this->created_at;
        $monthsOfMembering = $timeOfCreateUser->diffInMonths($now);
        if ($monthsOfMembering<3)
        {
            $timeOfMemberingPoints = 1;
        }elseif($monthsOfMembering<6)
        {
            $timeOfMemberingPoints = 2;
        }elseif($monthsOfMembering<12)
        {
            $timeOfMemberingPoints = 3;
        }elseif($monthsOfMembering<36)
        {
            $timeOfMemberingPoints = 4;
        }elseif($monthsOfMembering>=36)
        {
            $timeOfMemberingPoints = 5;
        }

        //calculate point of number of lots managing past
        // and
        //calculate sum of lottery views

        $myLotteries = Lottery::whereHas('lotterystocks', function($q){$q->where('owner', $this->id);})->orWhere('lottery_manager_id',LotteryManager::where('user_id',$this->id)->first()->id)->get();
        $myPastLotsPassed = array();
        $myPastLotteriesCountOfViews = array();
        foreach ($myLotteries as $myLottery) {
            $lots = Lot::where('lottery_id',$myLottery->id)->get();
            if ($myLottery->status == 'در حال عضوگیری' or $myLottery->lottery_manager_id != $this->lotterymanager->id)
            {
                continue;
            }else{
                $myPastLotsPassed[] = $lots->where('stock_winner','!=',NULL)->last()->number;
                $myPastLotteriesCountOfViews[] = $myLottery->count_of_view;
            }
        }
        $myPastLotsPassedCount =array_sum($myPastLotsPassed);
        if ($myPastLotsPassedCount<3)
        {
            $pastLotsPassedPoints = 1;
        }elseif($myPastLotsPassedCount<6)
        {
            $pastLotsPassedPoints = 2;
        }elseif($myPastLotsPassedCount<12)
        {
            $pastLotsPassedPoints = 3;
        }elseif($myPastLotsPassedCount<36)
        {
            $pastLotsPassedPoints = 4;
        }elseif($myPastLotsPassedCount>=36)
        {
            $pastLotsPassedPoints = 5;
        }

        $myPastLotteriesCountOfViewsSum =array_sum($myPastLotteriesCountOfViews);
        if ($myPastLotteriesCountOfViewsSum<100)
        {
            $myPastLotteriesCountOfViewsPoints = 1;
        }elseif($myPastLotteriesCountOfViewsSum<200)
        {
            $myPastLotteriesCountOfViewsPoints = 2;
        }elseif($myPastLotteriesCountOfViewsSum<500)
        {
            $myPastLotteriesCountOfViewsPoints = 3;
        }elseif($myPastLotteriesCountOfViewsSum<2000)
        {
            $myPastLotteriesCountOfViewsPoints = 4;
        }elseif($myPastLotteriesCountOfViewsSum>=2000)
        {
            $myPastLotteriesCountOfViewsPoints = 5;
        }

        $avgOfPoints  = intval(($timeOfMemberingPoints+$pastLotsPassedPoints+$myPastLotteriesCountOfViewsPoints)/3);
        $this->points = $avgOfPoints;
        $this->save();
    }

}
