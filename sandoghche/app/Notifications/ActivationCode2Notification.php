<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class ActivationCode2Notification extends Notification
{
    use Queueable;

    public $code;
    public $phoneNumber;
    public $template;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code,$phoneNumber)
    {
        $this->code = $code;
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
            'text' => "کد ثبت نام \n:%param1%\nصندوقچه\nلغو11",
            'number' => $this->phoneNumber,
            'param1' => $this->code,
            'param2' => null,
            'param3' => null,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'register',
        ];
    }


}
