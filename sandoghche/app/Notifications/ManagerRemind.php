<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class ManagerRemind extends Notification
{
    use Queueable;
    public $userName;
    public $lotteryName;
    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName,$lotteryName,$phoneNumber)
    {
        $this->userName = $userName;
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
            'text' => "%param1% عزیز\nموعد پرداخت اقساط صندوق %param2% نزدیک شده است.\nلطفا پرداختی هر یک از اعضا را تایید نمایید.\nبا تشکر - صندوقچه",
            'number' => $this->phoneNumber,
            'param1' => $this->userName,
            'param2' => $this->lotteryName,
            'param3' => null,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'ManagerRemind',
        ];
    }
}
