<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class InstallmentRemind extends Notification
{
    use Queueable;
    public $userName;
    public $lotteryName;
    public $deadline;
    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName,$lotteryName,$deadline,$phoneNumber)
    {
        $this->userName = $userName;
        $this->lotteryName = $lotteryName;
        $this->deadline = $deadline;
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
            'text' => "%param1% عزیز\nموعد پرداخت قسط شما در صندوق %param2% نزدیک شده است.\nلطفا تا قبل از %param3% پرداخت نمایید.\nصندوقچه",
            'number' => $this->phoneNumber,
            'param1' => $this->userName,
            'param2' => $this->lotteryName,
            'param3' => $this->deadline,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'InstallmentRemind',
        ];
    }
}
