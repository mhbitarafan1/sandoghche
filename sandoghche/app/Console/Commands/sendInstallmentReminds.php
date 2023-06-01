<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Lot;
use App\Installment;
use App\Lottery;
use App\LotteryStock;
use App\User;
use Carbon\Carbon;
use App\Notifications\InstallmentRemind;

class sendInstallmentReminds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendInstallmentReminds:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Installment Remind Notification like Sms dayli at 17';

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
     * @return int
     */
    public function handle()
    {

        $onTimeLots = Lot::where('time_holding','>', now())->where('time_holding','<=',
        Carbon::now()->addDays(2))->where('time_holding','>',Carbon::now()->addDays(1))->get();
        foreach ($onTimeLots as $onTimeLot) {
             $lotteryOfThisLot = lottery::where('id',$onTimeLot->lottery_id)->first();
            if ($lotteryOfThisLot->upgraded == false) {
                continue;
            }
            $installmentsNeedRemind = $onTimeLot->installments()->get();
            foreach ($installmentsNeedRemind as $installment) {

                $stockOwner = LotteryStock::where('id',$installment->lottery_stock_id)->first()->owner;

                if ($installment->paid == 0 && $stockOwner != null) {

                    //sendSms
                    $user = User::where('id',$stockOwner)->first();
                    $userName = $user->name;
                    $lotteryName = $lotteryOfThisLot->name;
                    $deadline = verta($onTimeLot->time_holding)->format('j %B %Y');
                    $phoneNumber = $user->phone_number;
                    $user->notify(new InstallmentRemind($userName,$lotteryName,$deadline,$phoneNumber));


                }


            }



        }










            $this->info('the Installment Remind Notifications Sent');


    }
}
