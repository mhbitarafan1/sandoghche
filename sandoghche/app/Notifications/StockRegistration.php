<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class StockRegistration extends Notification
{
    use Queueable;
    public $stockCount;
    public $lotteryName;
    public $lotteryManagerName;
    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($stockCount,$lotteryName,$lotteryManagerName,$phoneNumber)
    {
        $this->stockCount = $stockCount;
        $this->lotteryName = $lotteryName;
        $this->lotteryManagerName = $lotteryManagerName;
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
            'text' => "%param1% سهم از صندوق %param2% با مدیریت %param3% به شما تعلق گرفت. مشاهده جزئیات در اپلیکیشن صندوقچه
            \nhttps://cafebazaar.ir/app/ir.mhbitarafan.sandoghche
            \nصندوقچه\nلغو11",
            'number' => $this->phoneNumber,
            'param1' => $this->stockCount,
            'param2' => $this->lotteryName,
            'param3' => $this->lotteryManagerName,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'StockRegisteration',
        ];
    }
}
