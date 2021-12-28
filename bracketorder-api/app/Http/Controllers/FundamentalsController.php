<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class FundamentalsController extends Controller
{
    public function getFundamentals(Request $request)
    {
        $fundamentals = Cache::remember('profile_' . $request->input("ticker_symbol"), 25, function () use ($request) {

            $indexes = Controller::indexes($request);
            $fundamentals = Controller::fundamentals($request);

            $index_name = [];

            foreach ($indexes as $index) {
                if(strtoupper(substr($request->input("ticker_symbol"), 0, -5)) == $index['Code']) {
                    array_push($index_name, ['Name' => $index['Name'], 'Code' => $index['Code']]);
                }
            }

            if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
                return response()->json($index_name, 200);
            } else {
                return response()->json($fundamentals, 200);
            }
        });

        $json = json_encode($fundamentals);

        $array = json_decode($json, true);

        if (Cache::has('profile_' . $request->input('ticker_symbol')) && array_key_exists('original', $array)) {
            return response()->json($fundamentals->original, 200);
        } else {
            return response()->json($fundamentals, 200);
        }
    }
}
