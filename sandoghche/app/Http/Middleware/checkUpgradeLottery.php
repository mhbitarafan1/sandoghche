<?php

namespace App\Http\Middleware;

use App\Lottery;
use Closure;

class checkUpgradeLottery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $LotteriesManageNotUpgraded = Lottery::where('lottery_manager_id',auth()->user()->lotterymanager->id)->where('upgraded','!=',1)->where('status','!=','پایان یافته')->get();
        foreach ($LotteriesManageNotUpgraded as $lottery)
        {
            $nextLot = $lottery->lots->where('stock_winner','=',NULL)->first()->number;
            if($nextLot >= 4)
            {
                return redirect()->route('lottery.upgrade.showpage',[$lottery->id]);
            }
        }
//
        return $next($request);
    }
}
