<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class GetCurrencyController extends Controller
{
    public function index() {
        return response('Просто текст') -> header('content-type', 'text/plain');
    }

    public function getCurrency(string $date_start, Request $request) {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }


        if (!$date_start) {
            return response()->json(['error' => 'Date range not specified'], 400);
        }

        $url = "https://cbr.ru/scripts/XML_daily.asp?date_req=$date_start";

        $xml = simplexml_load_file($url);

        $filtered_currencies = [];
        foreach ($xml->Valute as $valute) {
            $currency_code = (string) $valute->CharCode;
            if (in_array($currency_code, ['USD', 'EUR', 'CNY'], true)) {
                $value = str_replace(',', '.', $valute->Value);
                $valute_arr = [
                    'NumCode' => (string) $valute->NumCode,
                    'CharCode' => $currency_code,
                    'Nominal' => (int) $valute->Nominal,
                    'Name' => (string) $valute->Name,
                    'Value' => floatval($value),
                ];
                $filtered_currencies[$currency_code] = $valute_arr;
            }
        }

        return response()->json($filtered_currencies, 200);

    }
}
