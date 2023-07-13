<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StockRequest;
use App\Lottery;
use App\User;
use App\Http\Requests\StoreStockRequest;
use App\LotteryMember;
use App\LotteryManager;
use App\LotteryStock;
use App\Invite;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\StockConfirm;
use App\Notifications\StockRegistration;
use App\Notifications\CancellOwnerStockByLotteryManager;
use App\Notifications\SaleStockConfirm;
use PhpParser\Node\Expr\Isset_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StockRequestController extends Controller
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
    public function create($id,$type)
    {
        $lottery= lottery::find($id);

        return view('users.stockRequests.create',compact('lottery','type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStockRequest $request)
    {
        $lotteryId = $request->lotteryId;
        $lotteryMemberId = LotteryMember::where('user_id',auth()->user()->id)->first()->id;
        if(count(stockRequest::where('lottery_id',$lotteryId)->where('lottery_member_id',$lotteryMemberId)->where('accepted_by_lotterymanager',false)->get())>0){
            Alert::warning('درخواست تکراری‌!','بعد از مشخص شدن نتیجه ی درخواست قبلی دوباره میتوانید درخواست جدید دهید');
            return redirect(route('lotteries.show',$lotteryId));
        }


            if ($request->type=='sell') {
                $lotteryStocks = LotteryStock::where('lottery_id',$lotteryId)->get();
                $selfStocks = $lotteryStocks->where('owner', auth()->user()->id)->all();

                if($request->count_of_lots > count($selfStocks)){

                    Alert::warning('تعداد غیرمجاز','تعداد سهام قابل فروش شما کمتر از تعداد انتخابی می باشد');
                    return redirect(route('lotteries.show',$lotteryId));


                }
            }



        $stockRequest = StockRequest::create([
            'lottery_id'=> $lotteryId,
            'lottery_member_id'=>  $lotteryMemberId ,
            'count_of_stock'=>$request->count_of_lots,
            'type_of_request'=>$request->type,
        ]);
        Alert::success('ارسال موفق','درخواست شما با موفقیت ارسال شد');
        return redirect(route('lotteries.show',$lotteryId));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        if ($stockRequest = StockRequest::where('id',$id)->first()) {
        $lottery_id = StockRequest::find($id)->lottery_id;
        // $stockRequest = StockRequest::where('id',$id)->first();
        if(!$stockRequest->accepted_by_lotterymanager){
            StockRequest::where('id',$id)->delete();
        }else{
            Alert::warning('ناموفق','این درخواست قبلا مورد تایید مدیر قرعه کشی قرار گرفته و دیگر امکان حذف آن نیست');
        }

         return redirect(route('lotteries.show',$lottery_id));
        }
        Alert::warning('ناموفق','درخواست شما قبلا توسط مدیر صندوق رد شده است');
        return back();

    }

    public function answerStockRequest(Request $request, $id)
    {
        if (!isset(StockRequest::find($id)->lottery_id)) {
            Alert::warning('','این درخواست قبلا توسط کاربر لغو شده است');
            return back();
        }


        $lottery_id = StockRequest::find($id)->lottery_id;
        if (isset($request->yes)) {
            $stockRequest = StockRequest::where('id',$id);
            $lotteryId = $stockRequest->first()->lottery_id;
            $lotteryStocks = LotteryStock::where('lottery_id',$lotteryId)->get();
            $countOfStockRequest = $stockRequest->first()->count_of_stock;
            $stockRequestUserid = LotteryMember::find($stockRequest->first()->lottery_member_id)->user_id;

            if ($stockRequest->first()->type_of_request=='buy') {

                 $freeStocks = $lotteryStocks->where('owner',NULL)->all();


                 $onTimeLot = Lottery::find($lotteryId)->lots->where('stock_winner',NULL)->first();

                 $freeAndGoodDeallerStoksId=[];

                 foreach ($freeStocks as $freeStock) {
                    $paidInstallments = $freeStock->installments->where('lot_id','<=',$onTimeLot->id)->where('paid',true);

                     if(count($paidInstallments) >= ($onTimeLot->number-1))
                    {
                     $freeAndGoodDeallerStoksId[] =  $freeStock->id;
                    }
                 }






                $countOfStockRequest = $stockRequest->first()->count_of_stock;
                if ($countOfStockRequest <= count($freeAndGoodDeallerStoksId)) {


                    DB::transaction(function () use($countOfStockRequest,$lotteryStocks,$freeAndGoodDeallerStoksId,$stockRequestUserid,$lottery_id,$stockRequest) {
                    for ($i=1; $i <= $countOfStockRequest ; $i++) {
                        $lotteryStocks->where('id',$freeAndGoodDeallerStoksId[$i-1])->first()->update([
                             'owner'=>$stockRequestUserid,
                        ]);
                    }
                    //sendSms
                    $user = User::where('id',$stockRequestUserid)->first();
                    $phoneNumber = $user->phone_number;
                    $userName = User::where('id',$stockRequestUserid)->first()->name;
                    $lotteryName = Lottery::where('id',$lottery_id)->first()->name;
                    $user->notify(new StockConfirm($userName,$countOfStockRequest,$lotteryName,$phoneNumber));
                    $stockRequest->update(['accepted_by_lotterymanager'=>true,]);
                    $userInvites = Invite::where('phone_number',$user->phone_number)->where('lottery_id',$lottery_id);
                    $userInvites->delete();
                    });

                    Alert::success('موفقیت آمیز');
                }else{

                    Alert::warning('سهام به مقدار کافی موجود نمی باشد', 'سهامی قابل واگذاری است که تحت مالکیت هیچ شخصی نباشد و هیچ قسطی بدهکار نباشد');
                    return back();
                }
            }elseif($stockRequest->first()->type_of_request=='sell'){


                $selfStocks = $lotteryStocks->where('owner', $stockRequestUserid)->all();
                if ($countOfStockRequest <= count($selfStocks) ) {


                    DB::transaction(function () use($countOfStockRequest,$lotteryStocks,$stockRequestUserid,$stockRequest) {
                    for ($i=1; $i <= $countOfStockRequest ; $i++) {
                        $lotteryStocks->where('owner',$stockRequestUserid)->first()->update([
                             'owner'=> NULL,
                        ]);
                    }
                    $stockRequest->update(['accepted_by_lotterymanager'=>true,]);
                    });

                    //sendSms
                    $user = User::where('id',$stockRequestUserid)->first();
                    $userName = $user->name;
                    $lotteryName = Lottery::where('id',$lottery_id)->first()->name;
                    $phoneNumber = $user->phone_number;
                    $user->notify(new SaleStockConfirm($userName,$countOfStockRequest,$lotteryName,$phoneNumber));





                }else{
                    Alert::warning('خطا', 'کاربر مورد نظر به تعداد کافی سهام ندارد');
                    return back();
                }

            }






        }elseif (isset($request->no)) {
            StockRequest::where('id',$id)->delete();
        }

        return redirect(route('lotteries.show',$lottery_id));




    }


    public function changeStockOwner(Request $request,$id)
    {

        $stock = LotteryStock::where('id',$id)->first();
        $lottery = Lottery::find($stock->lottery_id);
        $LotteryManagerUserId = LotteryManager::find((Lottery::find($stock->lottery_id)->lottery_manager_id))->user_id;

        if ($lottery->type_of_income == 'firstlot' && $stock->owner == $LotteryManagerUserId && count($lottery->lotteryStocks->where('owner',$LotteryManagerUserId))<2 && count($lottery->lots->where('stock_winner','<>',null))==0) {

            Alert::warning('عدم امکان واگذاری سهام', 'صندوق شما از نوع قرعه ی اول برای مدیر صندوق می باشد و نمیتوانید همه ی سهام های خودتان را  تا قبل از شروع قرعه کشی بفروشید');
            return back();

        }

        $userId = $stock->owner;
        $stock->update([
            'owner'=>NULL,
        ]);

        //send sms
        $user = User::where('id',$userId)->first();

        $userName = $user['name'];
        $stockNumber = $stock->number;
        $lotteryName = $lottery->name;
        $phoneNumber = $user['phone_number'];
        $user->notify(new CancellOwnerStockByLotteryManager($userName,$stockNumber,$lotteryName,$phoneNumber));

        $lotteryId = $stock->lottery_id;
        return redirect(route('stocks.lottery.index',$lotteryId));

    }
    public function addStockforLotteryManager($id)
    {
        $stock = LotteryStock::find($id);
        if ($stock->owner == NULL) {
            $stock->update([
                'owner' => User::find(LotteryManager::find(lottery::find($stock->lottery_id)->lottery_manager_id)->user_id)->id,
            ]);
            Alert::success('موفقیت آمیز', 'سهام مورد نظر متعلق به شما شد');
            return back();
        }else{
            Alert::warning('ناموفق', 'این سهام متعلقق به کس دیگری می باشد');
            return back();
        }

    }

    public function addStockforLotteryMember($id)
    {
        $stock = LotteryStock::find($id);
        $userAddStock = User::where('phone_number',$_REQUEST['phone_number'])->first();

        if ($stock->owner == NULL) {

            if ($userAddStock == null) {

                DB::transaction(function () use(&$userAddStock)  {
    				$userAddStock = User::create([
                        'name' => $_REQUEST['name'],
                        'phone_number' => $_REQUEST['phone_number'],
                        'password' => Hash::make('bkc9615d'),
                    ]);

    				LotteryMember::create([
    				    'user_id' => $userAddStock->id,
    				]);
    				LotteryManager::create([
    				    'user_id' => $userAddStock->id,
    				]);
                });


                $stock->update([
                    'owner' => User::where('phone_number',$_REQUEST['phone_number'])->first()->id,
                ]);

            }else {

                $stock->update([
                    'owner' => User::where('phone_number',$_REQUEST['phone_number'])->first()->id,
                ]);


            }

             //sendSms
             $lotteryId = $stock->lottery_id;
             $phoneNumber = $userAddStock->phone_number;
             $userName = 'دوست';
             $lotteryName = Lottery::where('id',$lotteryId)->first()->name;
             $lotteryManagerName = User::find(LotteryManager::find(Lottery::where('id',$lotteryId)->first()->lottery_manager_id)->user_id)->name;
             $countOfStockRequest = 'یک';
             $userAddStock->notify(new StockRegistration($countOfStockRequest,$lotteryName,$lotteryManagerName,$phoneNumber));
             $userInvites = Invite::where('phone_number',$userAddStock->phone_number)->where('lottery_id',$lotteryId);
             $userInvites->delete();

            Alert::success('موفقیت آمیز', 'مالکیت سهام مورد نظر تعلق گرفت');
            return back();


        }else{
            Alert::warning('ناموفق', 'این سهام متعلقق به کس دیگری می باشد');
            return back();
        }

    }

}
