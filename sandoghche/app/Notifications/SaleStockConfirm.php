<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class SaleStockConfirm extends Notification
{
    use Queueable;
    public $userName;
    public $stockCount;
    public $lotteryName;
    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName,$stockCount,$lotteryName,$phoneNumber)
    {
        $this->userName = $userName;
        $this->stockCount = $stockCount;
        $this->lotteryName = $lotteryName;
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsGhasedakChannel::class];
    }

    public function toGhasedakSms($notifiable)
    {
        return [
            'text' => "%param1% عزیز\nدرخواست واگذاری %param2% سهم شما در صندوق %param3% تایید شد.\nصندوقچه\nلغو11",
            'number' => $this->phoneNumber,
            'param1' => $this->userName,
            'param2' => $this->stockCount,
            'param3' => $this->lotteryName,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'SaleStockConfirm',
        ];
    }
}
