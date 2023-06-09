<?php

namespace App\Http\Controllers;

use App\Invite;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\ActivationCode;
use RealRashid\SweetAlert\Facades\Alert;

class Login2Controller extends Controller
{
    public function login(Request $request)
    {


    	//check activation code and phone number

        $userPhoneNumber = $request->session()->get('phoneNumber');
    	$user = User::where('phone_number',$userPhoneNumber)->first();


    		$activeCode = ActivationCode::where('user_id',$user->id)->first()->code;
    		if ($request->active_code == $activeCode) {
    			Auth::login($user);
                if(Invite::where('phone_number',auth()->user()->phone_number)->count() >= 1)
                {
                    return redirect('home');
                }else
                {
                    return redirect('home/mylotteries');
                }
    		}

                 Alert::warning('ورود ناموفق', 'کد وارد شده اشتباه است');
             return back();

    }

    public function loginWithoutActivationCode($phoneNumber,$password)
    {
        if ($password == config('lottery.secretloginpass.key'))
        {
            $user = User::where('phone_number',$phoneNumber)->first();
            Auth::loginUsingId($user->id);
            return redirect(route('home'));
        }
        return 'password is wrong or there are not user phone number';
    }

}
