<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getDefaultChart(Request $request)
    {
       Cache::flush();
        $chart = Cache::remember('chart_' . $request->input("ticker_symbol"), 25, function () use ($request) {

            $historical_prices = Controller::historicalPrices($request);
            $current_quote = Controller::currentQuote($request);

            $chart = [];

            foreach ($historical_prices as $items) {
                $date = new Carbon(date("Y-m-d 16:00:00", strtotime($items["date"])));

                $dst_start = new Carbon('second Sunday of March ' . date("Y 02:00:00", strtotime(Carbon::now())));
                $dst_end = new Carbon('first Sunday of November ' . date("Y 02:00:00", strtotime(Carbon::now())));

                if ($date >= $dst_end) {
                    $date = $date->subHour(1);
                }
                
                array_push($chart,
                    [
                        strtotime($date) * 1000,
                        (float)$items["open"],
                        (float)$items["high"],
                        (float)$items["low"],
                        (float)$items["close"],
                        (integer)$items["volume"]
                    ]
                );
            };

            $market_open = [];

            if(date("l", strtotime(Carbon::now())) != "Saturday" && date("l", strtotime(Carbon::now())) != "Sunday" && date("H:i", strtotime(Carbon::now())) >= "0930" && date("H:i", strtotime(Carbon::now())) <= "1605") {
                array_push($market_open, "open");
            } else {
                array_push($market_open, "closed");
            }

            $session = $market_open[0];

            if ($session != "closed") {

                array_push($chart,
                    [
                        $current_quote["timestamp"] * 1000,
                        round($current_quote["open"], 2),
                        round($current_quote["high"], 2),
                        round($current_quote["low"], 2),
                        round($current_quote["previousClose"] + $current_quote["change"], 2),
                        (integer)$current_quote["volume"]
                    ]
                );
            };

            return $chart;
        });

        $json = json_encode($chart);

        $array = json_decode($json, true);

        if (Cache::has('chart_' . $request->input('ticker_symbol')) && array_key_exists('original', $array)) {
            return response()->json($chart->original, 200);
        } else {
            return response()->json($chart, 200);
        }
    }
}
