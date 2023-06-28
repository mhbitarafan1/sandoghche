<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class ProblemNotification extends Notification
{
    use Queueable;
    public $userName;
    public $problemTitle;
    public $phoneNumber;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName,$problemTitle,$phoneNumber)
    {
        $this->userName = $userName;
        $this->problemTitle = $problemTitle;
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
            'text' => "%param1% عزیز\nبابت مشکل ایجادشده در %param2% پوزش می طلبیم و به زودی برطرف خواهد شد. سپاس از همراهی شما.\nصندوقچه",
            'number' => $this->phoneNumber,
            'param1' => $this->userName,
            'param2' => $this->problemTitle,
            'param3' => null,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'ProblemNotification',
        ];
    }

}
