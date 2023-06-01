<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Notifications\Channels\SmsGhasedakChannel;

class AnswerTicket extends Notification
{
    use Queueable;
    public $userName;
    public $titleTicket;
    public $phoneNumber;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($userName,$titleTicket,$phoneNumber)
    {
        $this->userName = $userName;
        $this->titleTicket = $titleTicket;
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
            'text' => "%param1% عزیز\nپاسخی به درخواست پشتیبانی شما با موضوع %param2% ارسال شده است.\nصندوقچه",
            'number' => $this->phoneNumber,
            'param1' => $this->userName,
            'param2' => $this->titleTicket,
            'param3' => null,
            'param4' => null,
            'param5' => null,
            'param6' => null,
            'param7' => null,
            'param8' => null,
            'param9' => null,
            'param10' =>null,
            'template' => 'AnswerTicket',
        ];
    }
}
