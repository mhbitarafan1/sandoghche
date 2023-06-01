<?php

namespace App\Notifications\Channels;

use Exception;
use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class SmsGhasedakChannel
{
    public function send($notifiable ,Notification $notification)
    {
        if (! method_exists($notification , 'toGhasedakSms')) {
            throw new Exception('toGhasedakSms Not found!!!!');
        }
        $data = $notification->toGhasedakSms($notifiable);
        $template = $data['template'];
        $receptor = $data['number'];
        $param1 = $data['param1'];
        $param2 = $data['param2'];
        $param3 = $data['param3'];
        $param4 = $data['param4'];
        $param5 = $data['param5'];
        $param6 = $data['param6'];
        $param7 = $data['param7'];
        $param8 = $data['param8'];
        $param9 = $data['param9'];
        $param10 = $data['param10'];
        $apiKey = config('services.ghasedak.key');
        try
        {

            // $template = "قالب شماره 1";
            // $param1 = "تست 1";
            // $param2 = "تست 2";
            $type = 1; // 1: sms , 2: voice
            $api = new \Ghasedak\GhasedakApi($apiKey);
            //  dd($template);
            $api->Verify( $receptor, $type, $template, $param1,$param2,$param3,$param4,$param5,
            $param6,$param7,$param8,$param9,$param10,);


        }
        catch(ApiException $e){
            throw $e;
        }
        catch(HttpException $e){
            throw $e;
        }
    }
}
