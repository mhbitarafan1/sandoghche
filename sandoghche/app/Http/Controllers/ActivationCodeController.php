<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\ActivationCode;
use App\Notifications\ActivationCodeNotification;
use RealRashid\SweetAlert\Facades\Alert;

class ActivationCodeController extends Controller
{
    public function showForm(Request $request)
    {
    	$user = User::where('phone_number',$request->phone_number)->first();

    	if ($user) {
    		$lastActiveCode = ActivationCode::where('user_id',$user->id)->first();

    		$lastActiveCodedontExpired = ActivationCode::where('user_id',$user->id)->where('expire_at','>',Carbon::now())->first();
    		if ($lastActiveCodedontExpired) {
    			$request->session()->put('phoneNumber',$request->phone_number);
            // return back();
            $phoneNumber = $request->phone_number;
            $dontSms = true;

    			return view('auth.showactivationform',['phoneNumber'=>$phoneNumber,'dontSms'=>$dontSms]);
    		}
    		if ($lastActiveCode) {
    			$lastActiveCode->delete();
    		}

            $code = rand(10000,99999);
    		$activeCode = ActivationCode::create([
    			'user_id'=>$user->id,
    			'code'=>$code,
    			'expire_at'=>Carbon::now()->addminutes(2),

    		]);



    		//send active code via sms
            $user->notify(new ActivationCodeNotification($code , $user->phone_number));


    		$request->session()->put('phoneNumber',$request->phone_number);

            $phoneNumber = $request->phone_number;
            return view('auth.showactivationform',['phoneNumber'=>$phoneNumber]);
    	}else{
    		return redirect(route('register'));
    	}


    }





}
