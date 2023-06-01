<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lot;
use App\LotteryStock;
use App\User;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use App\Lottery;
use App\LotteryManager;
use App\Notifications\WinnerLot;
use GuzzleHttp\Promise\Create;

class runLotsThisTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runLotsThisTime:hourly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Do lottery hourly at 1 minute';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

    $onTimeLots = Lot::where('time_holding','<', now())->where('stock_winner','=',NULL)->get();

    foreach ($onTimeLots as $onTimeLot) {
        unset($inclodedStocksOnLotId);
        $lotteryOfThisLot = lottery::where('id',$onTimeLot->lottery_id)->first();

        if($lotteryOfThisLot->type_of_choose_winner=='سیستم'){

                if ($lotteryOfThisLot->status=='در حال عضوگیری' && count($lotteryOfThisLot->lotterystocks->where('owner',null)) > count($lotteryOfThisLot->lotterystocks)/2) {
                    $lotLog = " قرعه کشی در زمان مقرر انجام نشد چون تعداد اعضا به حد نصاب نرسیده است\n";
                    $onTimeLot->update([
                        'log' => $lotLog,
                    ]);
                    continue;
                }

            if($lotteryOfThisLot->type_of_income=='firstlot' && $onTimeLot->number==1){
                if ($firstManagerStock = $lotteryOfThisLot->lotterystocks->where('owner',LotteryManager::find($lotteryOfThisLot->lottery_manager_id)->user_id)->first()) {
                    $firstManagerStock->update([
                                     'winned' => true,
                                ]);

                    $onTimeLot->update([
                        'stock_winner' => $firstManagerStock->id,
                    ]);

                    $lotteryOfThisLot->status = 'در حال برگزاری';
                    $lotteryOfThisLot->save();
                }
                if($onTimeLot->number==count(Lot::where('lottery_id',$lotteryOfThisLot->id)->get())){
                    $lotteryOfThisLot->status = 'پایان یافته';
                    $lotteryOfThisLot->save();
                    $lotteryOfThisLot->invites()->delete();
                    $lotteryOfThisLot->stockrequests()->delete();
                }


            }
            else {

                $stocksDontWinned=$lotteryOfThisLot->lotterystocks->where('winned',0);
                foreach ($stocksDontWinned as $stockDontWinned) {
                   $paidInstallments = $stockDontWinned->installments->where('lot_id','<=',$onTimeLot->id)->where('paid',true);


                    if(count($paidInstallments) >= $onTimeLot->number)
                   {
                    $inclodedStocksOnLotId[] =  $stockDontWinned->id;
                   }
                }
                if(isset($inclodedStocksOnLotId)){
                $winnerStockId = Arr::random($inclodedStocksOnLotId);
                $onTimeLot->update([
                    'stock_winner' => $winnerStockId,
                ]);
                $stockWinner = $lotteryOfThisLot->lotterystocks->where('id',$winnerStockId)->first();
                $stockWinner->update([
                    'winned' => true,
                ]);

                if ($onTimeLot->number==1) {
                    $lotteryOfThisLot->status = 'در حال برگزاری';
                    $lotteryOfThisLot->save();
                }
                if($onTimeLot->number==count(Lot::where('lottery_id',$lotteryOfThisLot->id)->get())){
                    $lotteryOfThisLot->status = 'پایان یافته';
                    $lotteryOfThisLot->save();
                    $lotteryOfThisLot->invites()->delete();
                    $lotteryOfThisLot->stockrequests()->delete();
                }




                //sendSms
                $winnerUserId = LotteryStock::where('id',$winnerStockId)->first()->owner;
                if ($user = User::where('id',$winnerUserId)->first()) {
                    $userName = $user->name;
                    $lotteryName =  $lotteryOfThisLot->name;
                    $phoneNumber = $user->phone_number;
                    $stockNumber = LotteryStock::where('id',$winnerStockId)->first()->number;
                    $user->notify(new WinnerLot($userName,$stockNumber,$lotteryName,$phoneNumber));
                }








                }else{

                    $lotLog = " قرعه کشی در زمان مقرر انجام نشد چون هیچ سهامی قابلیت شرکت در قرعه کشی را نداشت\n";
                    $onTimeLot->update([
                        'log' => $lotLog,
                    ]);
                }

            }




        }




    }










        $this->info('the lots runned');
    }
}
