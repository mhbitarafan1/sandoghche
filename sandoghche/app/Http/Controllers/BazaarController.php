<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class BazaarController extends Controller
{
    function validatePurchase($lottery, $token, $productId) {
        try {
            $access_token = $this->getAccessToken();
            $url = "https://pardakht.cafebazaar.ir/devapi/v2/api/validate/ir.mhbitarafan.sandoghche/inapp/$productId/purchases/$token/?access_token=$access_token";
            $response = Http::get($url);
            if ($response->getStatusCode() == 200 && $response->json()['purchaseState'] == 0) {
                $purchaseTime = (int)($response->json()['purchaseTime'] / 1000);
                $lottery->upgraded = true;
                $lottery->purchase_time = $purchaseTime;
                $lottery->purchase_product_id = $productId;
                $lottery->purchase_token = $token;
                $lottery->save();
                return true;
            }
            return false;
        } catch (\Exception $e) {
//            dd($e);
            return false;
        }
    }

    function getAccessToken()
    {
        $token = $this->getToken();
        if ($token != null) {
            return $token;
        } else {
            $token = $this->fetchAccessToken();
            $this->saveToken($token);
            return $token;
        }
    }

    function getToken()
    {
        try {
            if (cache()->has('bazaar_token'))
                return cache()->get('bazaar_token');
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    function saveToken($token)
    {
        cache()->put('bazaar_token', $token);
    }

    function fetchAccessToken()
    {
        try {
            $url = 'https://pardakht.cafebazaar.ir/devapi/v2/auth/token/';
            $refCode = "5tkb0UJ3URjrJuIhRlnPAzHhjZOoau";
            $data = [
                'grant_type' => 'refresh_token',
                'client_id' => '98hIPX8uzxyFauBWHvRLkwp9qBtTe0SPcfp3K2dM',
                'client_secret' => 'qU250a1p8bZ3SaPVt5iIxvwKpF5ui2xqURySYNOavZjEpJMyVdFXZtBZMFx0',
                'refresh_token' => $refCode
            ];
            $response = Http::asForm()->post($url, $data);
            return $response->json()['access_token'];
        } catch (\Exception $e) {
            return null;
        }
    }
}
