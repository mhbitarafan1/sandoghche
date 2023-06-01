<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Verta;
use Carbon\Carbon;
use App\Http\Requests\StoreLottery;
use App\Lottery;
use App\Lot;
use App\LotteryStock;
use App\LotteryManager;
use App\LotteryMember;
use App\Installment;
use App\User;
use RealRashid\SweetAlert\Facades\Alert;
class LotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {


        $lottery = Lottery::find($id);
        $newCountOfView = $lottery->count_of_view+1;
        $lottery->update(['count_of_view'=>$newCountOfView]);
        $lots = Lot::where('lottery_id',$id)->get();
        $stocks = LotteryStock::where('lottery_id',$id)->get();
        $users = User::all();
        $amIManager = $lottery->lottery_manager_id == auth()->user()->lotterymanager->id;
        $amIMember = $stocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all();

        $stockRequests = $lottery->stockrequests()->where('accepted_by_lotterymanager',0)->get();

        $lotteryMembers = LotteryMember::all();
        $memberId = $lotteryMembers->where('user_id',auth()->user()->id)->first()->id;
         $myStockRequest = $stockRequests->where('lottery_member_id',$memberId)->first();
         $lastLot=$lots->where('stock_winner','!=',NULL)->last();
         $nextLot=$lots->where('stock_winner','=',NULL)->first();
        $lotteryManagerUserId = LotteryManager::find($lottery->lottery_manager_id)->user_id;
        $stocksDontWinned=$lottery->lotterystocks->where('winned',0);

        return view('users.lots.index',compact('lottery','lots','users','stocks','amIManager','amIMember','stockRequests','lotteryMembers','myStockRequest','lastLot','nextLot','lotteryManagerUserId','stocksDontWinned'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function showWithoutAdvertise($id)
    {


        $lottery = Lottery::find($id);
        $newCountOfView = $lottery->count_of_view+1;
        $lottery->update(['count_of_view'=>$newCountOfView]);
        $lots = Lot::where('lottery_id',$id)->get();
        $stocks = LotteryStock::where('lottery_id',$id)->get();
        $users = User::all();
        $amIManager = $lottery->lottery_manager_id == auth()->user()->lotterymanager->id;
        $amIMember = $stocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all();

        $stockRequests = $lottery->stockrequests()->where('accepted_by_lotterymanager',0)->get();

        $lotteryMembers = LotteryMember::all();
        $memberId = $lotteryMembers->where('user_id',auth()->user()->id)->first()->id;
         $myStockRequest = $stockRequests->where('lottery_member_id',$memberId)->first();
         $lastLot=$lots->where('stock_winner','!=',NULL)->last();
         $nextLot=$lots->where('stock_winner','=',NULL)->first();
        $lotteryManagerUserId = LotteryManager::find($lottery->lottery_manager_id)->user_id;
        $stocksDontWinned=$lottery->lotterystocks->where('winned',0);

        return view('users.lots.index',compact('lottery','lots','users','stocks','amIManager','amIMember','stockRequests','lotteryMembers','myStockRequest','lastLot','nextLot','lotteryManagerUserId','stocksDontWinned'));


    }


}
