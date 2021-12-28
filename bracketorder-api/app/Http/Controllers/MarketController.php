<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

class MarketController extends Controller
{
    public function getMarkets()
    {
//        Cache::flush();
        $markets = Cache::remember('market_quotes', 25, function () {

            $markets = Controller::markets();

            $markets[0]["name"] = "Dow";
            $markets[1]["name"] = "S&P 500";
            $markets[2]["name"] = "Nasdaq";
            $markets[3]["name"] = "Russell 2000";

            $markets = [
                "markets" => $markets,

                "metadata" => [
                    "status" => 200,
                    "count" => count($markets),
                    "endpoint" => "http://bracketorder.com/api/bracketorder",
                    "method" => "GET",
                    "format" => "JSON",
                    "description" => "Returns an array of market indexes. Accepts no parameters."
                ]
            ];

            return $markets;
        });

        $json = json_encode($markets);

        $array = json_decode($json, true);

        if (Cache::has('market_quotes') && array_key_exists('original', $array)) {
            return response()->json($markets->original, 200);
        } else {
            return response()->json($markets, 200);
        }
    }
}
