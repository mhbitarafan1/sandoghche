<?php

namespace App\Http\Controllers;

use App\Notifications\ProblemNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Verta;
use Carbon\Carbon;
use App\Http\Requests\StoreLottery;
use App\Lottery;
use App\Lot;
use App\LotteryStock;
use App\LotteryManager;
use App\LotteryMember;
use App\Installment;
use App\Invite;
use App\User;
use App\LotteryReport;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\WinnerLot;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Null_;
use \App\Http\Controllers\BazaarController;

class LotteryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $myLotteries = Lottery::whereHas('lotterystocks', function($q){$q->where('owner', auth()->user()->id);})->orWhere('lottery_manager_id',LotteryManager::where('user_id',auth()->user()->id)->first()->id)->latest()->paginate(4, ['*'], 'myLotteries');
        $otherLotteries = Lottery::latest()->paginate(24, ['*'], 'otherLotteries');
        $users = User::all();
        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();

        $invites = Invite::where('phone_number',auth()->user()->phone_number)->get();
        $invitesLotteryIds=array();
        foreach ($invites as $invite) {
            $invitesLotteryIds[] = $invite->lottery_id;
        }
        $lotteryInvites=false;
        if ($invites->count()>=1) {
            $lotteryInvites = Lottery::whereIn('id',$invitesLotteryIds)->latest()->paginate(5);

        }

        $bestLotteries = Lottery::orderBy('count_of_view','DESC')->paginate(10);
        return view('users.home',compact('otherLotteries','users','lotteryManagers','lotteryStocks','myLotteries','lotteryInvites','bestLotteries'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('users.lotteries.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLottery $request)
    {
        //avoid creating Repeat lotteries
        if(auth()->user()->lotterymanager && Lottery::where('lottery_manager_id',auth()->user()->lotterymanager->id)->latest()->first() )
        {
            $isRepeat = (Lottery::where('lottery_manager_id',auth()->user()->lotterymanager->id)->latest()->first()->created_at <= now()->subSeconds(20))?false:true;
            if($isRepeat == true)
            {
                return redirect(route('my.lotteries'));
            }
        }
        //avoid creating more than 5 lottery
        $countLotteryManageNotFinishing = Lottery::where('lottery_manager_id',auth()->user()->lotterymanager->id)->where('status','!=','پایان یافته')->count();
        if ($countLotteryManageNotFinishing >= 5) {
            Alert::warning('ناموفق','امکان مدیریت بیش از ۵ صندوق که هنوز پایان نیافته نمی باشد');
            return redirect(route('home'));
        }
        $jalaliTime = Verta::createJalali($request->year,$request->month,$request->day,$request->hour,0,0);
        $miladiTime = Carbon::instance($jalaliTime->DateTime());

        if ($jalaliTime->lt(verta::tomorrow())) {
            return redirect()->back()->withErrors(['زمان شروع قرعه کشی  اشتباه است. حداقل یک روز  بعد را می توانید انتخاب کنید']);
        }
        $amount = str_replace(',', '', $request->amount);
        if (!is_numeric($amount)) {
            return back();
        }

        DB::transaction(function () use($miladiTime,$request,$amount,$jalaliTime) {
            $lottery = Lottery::create([
                'lottery_manager_id' => auth()->user()->lotterymanager->id,
                'time_of_first_lot' => $miladiTime,
                'slug' => str_replace(["صندوقچه","صندوق ","بانک ","سهام عدالت ","صندوق","بانک","سهام عدالت"],"",$request->name),
                "name" => str_replace(["صندوقچه","صندوق ","بانک ","سهام عدالت ","صندوق","بانک","سهام عدالت"],"",$request->name),
                "amount" => $amount,
                "cycle" => $request->cycle,
                "count_of_lots" =>$request->count_of_lots,
                "type_of_income" => $request->type_of_income,
                "type_of_choose_winner" => $request->type_of_choose_winner,
                "short_description" => $request->short_description,
            ]);


            $timeHoldingOfLotJalali = $jalaliTime;
            for ($i=1; $i <= $request->count_of_lots  ; $i++) {

                $lotteryStocksData[] = [
                    'lottery_id' => $lottery->id,
                    'number' => $i,
                ];




                switch ($request->cycle) {
                    case 'هفتگی':
                        if ($i!=1) {
                            $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addWeek();
                        }
                        break;
                    case 'دو هفته یکبار':
                        if ($i!=1) {
                            $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addWeeks(2);
                        }
                        break;
                    case 'ماهیانه':
                        if ($i!=1) {
                            $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonth();
                        }
                        break;
                    case 'دو ماه یکبار':
                        if ($i!=1) {
                            $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonths(2);
                        }
                        break;
                    default:
                        if ($i!=1) {
                            $timeHoldingOfLotJalali=$timeHoldingOfLotJalali->addMonth();
                        }
                        break;
                }


                $lotsData[] = [
                    'lottery_id' => $lottery->id,
                    'number' => $i,
                    'time_holding' =>Carbon::instance($timeHoldingOfLotJalali->DateTime()),
                    'amount' =>$amount,
                ];




            }




            $lotteryStock = LotteryStock::insert($lotteryStocksData);

            $lot = Lot::insert($lotsData);





            $lots = Lot::where('lottery_id',$lottery->id)->get();
            $stocks = LotteryStock::where('lottery_id',$lottery->id)->get();

            foreach ($lots as $lot) {
                foreach ($stocks as $stock) {

                    $installmentsData[] = [
                        'lot_id' => $lot->id,
                        'lottery_stock_id' => $stock->id,
                    ];


                }
            }


            $installment = Installment::insert($installmentsData);




            if ($lottery->type_of_income == 'firstlot') {
                $firstStock = $stocks->first();
                $firstStock->update([
                    'owner'=>auth()->user()->id,
                ]);


            }








        });
        $lotteryId = Lottery::where('lottery_manager_id',LotteryManager::where('user_id',auth()->user()->id)->first()->id)->latest()->first()->id;
        //    return redirect(route('invite.friends.create',[$lotteryId]));

        // Alert::success('موفقیت آمیز','صندوق با موفقیت ایجاد شد');
        return redirect(route('stocks.lottery.index',[$lotteryId]));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $otherLotteries = Lottery::latest()->paginate(6, ['*'], 'otherLotteries');
        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();



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

        return view('users.lotteries.show',compact('lottery','lots','users','stocks','amIManager','amIMember','stockRequests','lotteryMembers','myStockRequest','lastLot','nextLot','lotteryManagerUserId','stocksDontWinned','lotteryManagers','lotteryStocks'));
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
        return "ok";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $countOfPastLot=count(lottery::find($id)->lots->where('stock_winner','<>',NULL));
        if ($countOfPastLot < 1) {
            //Lot::where('lottery_id',$id)->delete();
            Lottery::where('id',$id)->first()->delete();
            Alert::success('موفقیت آمیز', 'قرعه کشی موردنظر با موفقیت حذف شد');
            return redirect(route('home'));
        }else{

            Alert::warning('حذف ناموفق', 'بعد از قرعه کشی  اول دیگر امکان حذف قرعه کشی نمی باشد');
            return back();
        }


    }



    public function chooseWinnerByManager(Request $request)
    {
        $lot = Lot::find($request->lot_id);
        $lotteryOfThisLot = lottery::where('id',$lot->lottery_id)->first();
        if ($lotteryOfThisLot->status=='در حال عضوگیری' && count($lotteryOfThisLot->lotterystocks->where('owner',null)) > count($lotteryOfThisLot->lotterystocks)/2) {
            Alert::warning('ناموفق', 'تعداد اعضا به حد نصاب نرسیده است');
            return back();
        }

        if(isset($request->stock_winner)){
            $winnerStockId = $request->stock_winner;
            $stockWinner = lotteryStock::find($winnerStockId);
            $lot = Lot::find($request->lot_id);



            DB::transaction(function () use($lot,$winnerStockId,$stockWinner) {
                $lot->update([
                    'stock_winner' => $winnerStockId,
                ]);

                $stockWinner->update([
                    'winned' => true,
                ]);



                $lotteryOfThisLot = lottery::where('id',$lot->lottery_id)->first();
                if ($lot->number==1) {
                    $lotteryOfThisLot->status = 'در حال برگزاری';
                    $lotteryOfThisLot->save();
                }
                if ($lot->number==count(Lot::where('lottery_id',$lotteryOfThisLot->id)->get())){
                    $lotteryOfThisLot->status = 'پایان یافته';
                    $lotteryOfThisLot->save();
                    $lotteryOfThisLot->invites()->delete();
                    $lotteryOfThisLot->stockrequests()->delete();
                }






            });

            //sendSms
            $winnerUserId = $stockWinner->owner;
            $lotteryOfThisLot = lottery::where('id',$lot->lottery_id)->first();
            if ($user = User::where('id',$winnerUserId)->first()) {
                $userName = $user->name;
                $lotteryName =  $lotteryOfThisLot->name;
                $phoneNumber = $user->phone_number;
                $stockNumber = $stockWinner->number;
                $user->notify(new WinnerLot($userName,$stockNumber,$lotteryName,$phoneNumber));
            }



            Alert::success('موفقیت آمیز', 'سهام مورد نظر با موفقیت به عنوان برنده انتخاب شد');
            return back();
        }

        Alert::warning('برنده را انتخاب نمایید', 'سهامی  جهت معرفی وجود ندارد');
        return back();

    }



    public function like($lotteryId)
    {

        $lottery = lottery::find($lotteryId);
        $likedCount = $lottery->count_of_like + 1;
        $lottery->update([
            'count_of_like'=>$likedCount,
        ]);
        return back();
    }
    public function lotterySearch(Request $request)
    {
        $lotteryInvites=false;
        $lotteriesSearched = true;
        if (isset($request->searchlottery) && $request->searchlottery != Null) {
            $searchLottery = $request->searchlottery;
            $myLotteries = Lottery::whereHas('lotterystocks', function($q){$q->where('owner', auth()->user()->id);})->orWhere('lottery_manager_id',LotteryManager::where('user_id',auth()->user()->id)->first()->id)->latest()->paginate(4, ['*'], 'myLotteries');
            $otherLotteries = Lottery::where('name','like','%'.$searchLottery.'%')->latest()->paginate(24, ['*'], 'otherLotteries');
            $users = User::all();
            $lotteryManagers = LotteryManager::all();
            $lotteryStocks = LotteryStock::all();

            return view('users.home',compact('lotteriesSearched','otherLotteries','users','lotteryManagers','lotteryStocks','myLotteries','lotteryInvites'));
        }else{
            return back();
        }






    }

    public function myLotteries()
    {

        $myLotteries = Lottery::whereHas('lotterystocks', function($q){$q->where('owner', auth()->user()->id);})->orWhere('lottery_manager_id',LotteryManager::where('user_id',auth()->user()->id)->first()->id)->latest()->paginate(4, ['*'], 'myLotteries');
        $otherLotteries = Lottery::latest()->paginate(6, ['*'], 'otherLotteries');
        $users = User::all();
        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();
        $justMyLotteries = true;

        return view('users.home',compact('otherLotteries','users','lotteryManagers','lotteryStocks','myLotteries','justMyLotteries'));

    }

    public function reportLotteryCreate($lotteryId)
    {
        return view('users.lotteries.reportcreate',compact('lotteryId'));

    }

    public function reportLotteryStore (Request $request)
    {
        LotteryReport::create([
            'title' => $request->title,
            'description' => $request->description,
            'lottery_id' => $request->lottery_id,
            'user_id' =>  auth()->user()->id,
        ]);

        Alert::success('موفقیت آمیز', 'گزارش شما دریافت شد و به زودی توسط کارشناسان بررسی خواهد شد. سپاس ');
        return redirect(route('home'));

    }

    public function inviteFriendsCreate($lotteryId)
    {
        $lottery = Lottery::where('id',$lotteryId)->first();

        if ($lottery->lottery_manager_id == auth()->user()->lotterymanager->id) {
            return view('users.invites.create',compact('lottery'));
        }else{
            return 'شما دسترسی به دعوت اعضا در این صندوق را ندارید';
        }

    }
    public function inviteFriendsStore (Request $request)
    {
        $lotteryId = $request->lotteryId;
        for ($i=1; $i <= 10; $i++) {
            $phoneNumber = 'phone_number'."$i";
            if ($request->$phoneNumber and $request->$phoneNumber != auth()->user()->phone_number) {
                Invite::create([
                    'lottery_id' => $lotteryId,
                    'phone_number' => $request->$phoneNumber,
                ]);


                $lotteryName = Lottery::where('id',$lotteryId)->first()->name;
                $lotteryManagerName = User::find(LotteryManager::find(Lottery::where('id',$lotteryId)->first()->lottery_manager_id)->user_id)->name;
                //sendSms
                try
                {
                    $template = "StockRequestRegisteration";
                    $param1 = "دوست";
                    $param2 = $lotteryName;
                    $param3 = $lotteryManagerName;
                    $receptor = $request->$phoneNumber;
                    $type = 1; // 1: sms , 2: voice
                    $api = new \Ghasedak\GhasedakApi(config('services.ghasedak.key'));
                    $api->Verify( $receptor, $type, $template, $param1, $param2,$param3);
                }
                catch(\Ghasedak\Exceptions\ApiException $e){
                    echo $e->errorMessage();
                }
                catch(\Ghasedak\Exceptions\HttpException $e){
                    echo $e->errorMessage();
                }







            }
        }

        Alert::success('موفق','درخواست ارسال دعوت شما با موفقیت ثبت شد');
        return redirect(route('lotteries.show',[$lotteryId]));
    }

    public function lotteryUpgradeShowPage($lotteryId)
    {
        $lottery = Lottery::where('id',$lotteryId)->first();

        if ($lottery->lottery_manager_id == auth()->user()->lotterymanager->id) {
            $productId = $this->getProductIdFromLottery($lottery);
            return view('users.lotteries.upgrade',compact('lottery', 'productId'));
        }else{
            return 'شما دسترسی به دعوت اعضا در این صندوق را ندارید';
        }

    }

    public function lotteryPayShowPage($lotteryId, $productId)
    {
        $lottery = Lottery::where('id',$lotteryId)->first();

        if ($lottery->lottery_manager_id == auth()->user()->lotterymanager->id) {
            return view('users.lotteries.pay',compact('lottery', 'productId'));
        }else{
            return 'شما دسترسی به دعوت اعضا در این صندوق را ندارید';
        }

    }

    public function lotteryStocksShowPage($id)
    {

        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();

        $lottery = Lottery::find($id);

        $lots = Lot::where('lottery_id',$id)->get();
        $stocks = LotteryStock::where('lottery_id',$id)->get();
        $users = User::all();
        $amIManager = $lottery->lottery_manager_id == auth()->user()->lotterymanager->id;
        $amIMember = $stocks->where('lottery_id',$lottery->id)->where('owner',auth()->user()->id)->all();


        $lotteryMembers = LotteryMember::all();
        $memberId = $lotteryMembers->where('user_id',auth()->user()->id)->first()->id;
        $lastLot=$lots->where('stock_winner','!=',NULL)->last();
        $nextLot=$lots->where('stock_winner','=',NULL)->first();
        $lotteryManagerUserId = LotteryManager::find($lottery->lottery_manager_id)->user_id;
        $stocksDontWinned=$lottery->lotterystocks->where('winned',0);

        return view('users.stocks.index',compact('lottery','lots','users','stocks','amIManager','amIMember','lotteryMembers','lastLot','nextLot','lotteryManagerUserId','stocksDontWinned','lotteryManagers','lotteryStocks'));


    }




    public function showLotteryInfo($id)
    {
        $lotteryManagers = LotteryManager::all();
        $lotteryStocks = LotteryStock::all();
        $lottery = Lottery::find($id);
        $users = User::all();
        return view('users.lotteries.info',compact('lottery','users','lotteryManagers','lotteryStocks'));


    }


    public function getProductIdFromLottery($lottery){
        try {
            $count = $lottery->count_of_lots;
            $productId = null;
            switch(true) {
                case $count <= 20: $productId = 1; break;
                case $count <= 40: $productId = 2; break;
                case $count <= 60: $productId = 3; break;
                case $count <= 80: $productId = 4; break;
                case $count <= 100: $productId = 5; break;
                default: $productId = 6; break;
            }
            return $productId;
        } catch (\Exception $e) {
            return 6;
        }
    }

    public function validateLotteryPurchase($lotteryId, $productId) {
        $lottery = Lottery::find($lotteryId);
        $token = request('token');
        $lottery->purchase_product_id = $productId;
        $lottery->purchase_token = $token;
        $lottery->save();
        $isValid = (new BazaarController())->validatePurchase($lottery, $token, $productId);
        return response()->json(['is_valid' => $isValid]);
    }
    public function clearCache(){
        Artisan::call('route:clear');
        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('optimize');
        return 'ok';
    }
    public function sendSms($type){
        return 'جهت ارسال اس ام اس خط اول فانکشن سند اس ام اس در لاتاری کنترلر کامنت شود. با سپاس';
        $lotteries = Lottery::all();
        switch ($type)
        {
            case "problemnotification":
                $sentUsersIds = array();
                foreach ($lotteries as $lottery)
                {
                    //send SMS problem notification for manager of Lottery
                    $lotteryManager = User::where('id',LotteryManager::where('id',$lottery->lottery_manager_id)->first()->user_id)->first();
//                    $userName = $lotteryManager->name;
                    if (!in_array($lotteryManager->id,$sentUsersIds))
                    {
                        $userName = 'کاربر';
                        $problemTitle = 'نصب اپلیکیشن';
                        $phoneNumber = $lotteryManager->phone_number;
                        $lotteryManager->notify(new ProblemNotification($userName,$problemTitle,$phoneNumber));
                        $sentUsersIds[] = $lotteryManager->id;
                    }
                }
                break;



        }
        return 'sms sent';
    }
    public function redirectToLogin(){
        return redirect('/login');
    }
    public function articlesDone(){
        return 'done';
    }
    public function showPolicy(){
        return view('policy');
    }
    public function usersDocuments(){
        return view('users.documents.index');
    }
    public function usersDonates(){
        return view('users.donates.index');
    }
    public function donateAdvertise(){
        return 'inja safheye show advertise dar donate hast';
    }
    public function lotteryUpgrade(){
        return 'inja safheye upgrade sandogh hast';
    }
    public function advertiseShow(){
        return 'inja safheye show advertise hast';
    }

}
