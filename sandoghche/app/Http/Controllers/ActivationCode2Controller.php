<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\ActivationCode2;
use Illuminate\Support\Facades\Validator;
use App\Notifications\ActivationCode2Notification;


class ActivationCode2Controller extends Controller
{
	public function showForm(Request $request)
	{
		$this->validator($request->all())->validate();

		$user = User::where('phone_number',$request->phone_number)->first();

		if (!$user) {
			$lastActiveCode = ActivationCode2::where('phone_number',$request->phone_number)->first();
			$lastActiveCodedontExpired = ActivationCode2::where('phone_number',$request->phone_number)->where('expire_at','>',Carbon::now())->first();
			if ($lastActiveCodedontExpired) {
				$request->session()->put('phoneNumber',$request->phone_number);
				$request->session()->put('Name',$request->name);

                $phoneNumber = $request->phone_number;
                $dontSms = true;

				return view('auth.showactivationform2',['phoneNumber'=>$phoneNumber,'dontSms'=>$dontSms]);
			}
			if ($lastActiveCode) {
				$lastActiveCode->delete();
			}
			$activeCode = ActivationCode2::create([
				'phone_number'=>$request->phone_number,
				'code'=>rand(10000,99999),
				'expire_at'=>Carbon::now()->addminutes(2),

			]);

            //sending sms
            $userBeforeRegister = ActivationCode2::where('phone_number',$request->phone_number)->first();
            $userBeforeRegister->notify(new ActivationCode2Notification($activeCode->code , $request->phone_number));

			$request->session()->put('phoneNumber',$request->phone_number);
			$request->session()->put('Name',$request->name);

            $phoneNumber = $request->phone_number;
			return view('auth.showactivationform2',['phoneNumber'=>$phoneNumber]);
		}else{
			return redirect(route('login'));
		}


	}

	        protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'phone_number' => ['required', 'digits:11', 'unique:users,phone_number'],
        ]);
    }



}
