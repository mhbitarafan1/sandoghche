<?php

namespace App\Http\Controllers;

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
    		return redirect('home/mylotteries');
    		}

                 Alert::warning('ورود ناموفق', 'کد وارد شده اشتباه است');
             return back();

    }
}
