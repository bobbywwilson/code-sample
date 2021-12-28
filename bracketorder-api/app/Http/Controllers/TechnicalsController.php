<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TechnicalsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param $ticker_symbol
     * @internal param $from
     * @internal param $to
     */
    public function getTechnicals(Request $request)
    {
        Cache::flush();
        $technicals = Cache::remember('technicals_' . $request->input('ticker_symbol'), 25, function () use ($request) {

            $historical_prices = Controller::historicalPrices($request);
            $current_quote = Controller::currentQuote($request);

            $periods_21 = 21;
            $periods_63 = 63;
            $periods_200 = 200;
            $periods_14 = 14;
            $periods_28 = 28;
            $periods_42 = 42;
            $stochastic_k = 14;
            $stochastic_d = 3;
            $periods_boll = 20;
            $upper_sdv = 2;
            $lower_sdv = 2;
            $macd_fast = 12;
            $macd_slow = 26;
            $macd_smooth = 9;

            $adjusted_close = [];

            $stochastic_high = [];
            $stochastic_low = [];
            $stochastic_close = [];

            foreach ($historical_prices as $items) {
                array_push($adjusted_close, $items["close"]);
            }

            foreach ($historical_prices as $items) {
                array_push($stochastic_high, $items["high"]);
            }

            foreach ($historical_prices as $items) {
                array_push($stochastic_low, $items["low"]);
            }

            foreach ($historical_prices as $items) {
                array_push($stochastic_close, $items["close"]);
            }

            $market_open = [];

            if(date("l", strtotime(Carbon::now())) != "Saturday" && date("l", strtotime(Carbon::now())) != "Sunday" && date("H:i", strtotime(Carbon::now())) >= "0930" && date("H:i", strtotime(Carbon::now())) <= "1605") {
                array_push($market_open, "open");
            } else {
                array_push($market_open, "closed");
            }

            $session = $market_open[0];

            if ($session != "closed") {
//                dd($session);
//                array_pop($adjusted_close);
//                array_pop($stochastic_high);
//                array_pop($stochastic_low);
//                array_pop($stochastic_close);

                array_push($adjusted_close, ($current_quote["previousClose"] + $current_quote["change"]));

                array_push($stochastic_high, $current_quote["high"]);

                array_push($stochastic_low, $current_quote["low"]);

                array_push($stochastic_close, $current_quote["close"]);
            }
            $adjusted_close_dec = array_reverse($adjusted_close);

            $trend = [];
            $variance_sum = 0;
            for($i = 0; $i < count($adjusted_close_dec) - 1; $i++) {
                $variance = (float)$adjusted_close_dec[$i] - (float)$adjusted_close_dec[$i + 1];
                $variance_sum += $variance;
                array_push($trend, ((float)$variance_sum)/((float)$adjusted_close_dec[0]));
            }

            $trend = array_reverse($trend);

            $sma_21 = trader_sma($adjusted_close_dec, $periods_21);

            $sma_63 = trader_sma($adjusted_close_dec, $periods_63);

            $sma_200 = trader_sma($adjusted_close_dec, $periods_200);

            $bollinger = trader_bbands($adjusted_close_dec, $periods_boll, $upper_sdv, $lower_sdv, TRADER_MA_TYPE_SMA);

            $macd_signal_divergence = trader_macd(array_reverse($adjusted_close_dec), $macd_fast, $macd_slow, $macd_smooth);

            $rsi_14 = trader_rsi($adjusted_close, $periods_14);

            $rsi_28 = trader_rsi($adjusted_close, $periods_28);

            $rsi_42 = trader_rsi($adjusted_close, $periods_42);

            $stochastic = trader_stochf($stochastic_high, $stochastic_low, $stochastic_close, $stochastic_k, $stochastic_d, TRADER_MA_TYPE_SMA);

            $current_price = ($current_quote["previousClose"] + $current_quote["change"]);

            $signals = [];

            if($sma_21[20] > $sma_63[62] && $sma_63[62] > $sma_200[199]) {
                array_push($signals, ['sma_signal' => "uptrend"]);
            } elseif ($sma_63[62] > $sma_21[20] && $sma_21[20] > $sma_200[199]) {
                array_push($signals, ['sma_signal' => "down reversal"]);
            } elseif ($sma_21[20] > $sma_200[199] && $sma_200[199] > $sma_63[62]) {
                array_push($signals, ['sma_signal' => "up reversal"]);
            } elseif ($sma_200[199] > $sma_63[62] && $sma_63[62] > $sma_21[20]) {
                array_push($signals, ['sma_signal' => "downtrend"]);
            } elseif ($sma_200[199] > $sma_21[20] && $sma_21[20] > $sma_63[62]) {
                array_push($signals, ['sma_signal' => "up reversal"]);
            } elseif ($sma_200[199] > $sma_21[20] && $sma_21[20] < $sma_63[62]) {
                array_push($signals, ['sma_signal' => "downtrend"]);
            }

            if($current_price >= $bollinger[0][19]) {
                array_push($signals, ['bb_signal' => "overbought"]);
            } elseif ($current_price < $bollinger[0][19] && $current_price > $bollinger[1][19]) {
                array_push($signals, ['bb_signal' => "caution"]);
            } elseif ($current_price < $bollinger[1][19] && $current_price > $bollinger[2][19]) {
                array_push($signals, ['bb_signal' => "caution"]);
            } elseif ($current_price <= $bollinger[2][19]) {
                array_push($signals, ['bb_signal' => "oversold"]);
            }

            if(round(end($rsi_14), 0) < 70 && round(end($rsi_14), 0) > 30) {
                array_push($signals, ['rsi_signal' => "caution"]);
            } elseif (round(end($rsi_14), 0) >= 70) {
                array_push($signals, ['rsi_signal' => "overbought"]);
            } elseif (round(end($rsi_14), 0) <= 30) {
                array_push($signals, ['rsi_signal' => "oversold"]);
            }

            if($signals[2]["rsi_signal"] == "caution") {
                array_push($signals, ['macd_signal' => "caution"]);
            } elseif ($signals[2]["rsi_signal"] == "overbought") {
                array_push($signals, ['macd_signal' => "overbought"]);
            } elseif ($signals[2]["rsi_signal"] == "oversold") {
                array_push($signals, ['macd_signal' => "oversold"]);
            }

            if(round(end($stochastic[0]), 0) < 80 && round(end($stochastic[1]), 0) > 20) {
                array_push($signals, ['stochastic_fast_signal' => "caution"]);
            } elseif (round(end($stochastic[0]), 0) >= 80 || round(end($stochastic[1]), 0) >= 80) {
                array_push($signals, ['stochastic_fast_signal' => "overbought"]);
            } elseif (round(end($stochastic[1]), 0) <= 20 || round(end($stochastic[1]), 0) <= 20) {
                array_push($signals, ['stochastic_fast_signal' => "oversold"]);
            }

            $technicals = [
                "symbol" => $request->input("ticker_symbol"),
                "timestamp" => $current_quote["timestamp"],
                "sma" => [
                    "sma_21" => round($sma_21[20], 2),
                    "sma_63" => round($sma_63[62], 2),
                    "sma_200" => round($sma_200[199], 2),
                    "sma_signal" => $signals[0]["sma_signal"]
                ],
                "bollinger_bands" => [
                    "upper" => round($bollinger[0][19], 2),
                    "middle" => round($bollinger[1][19], 2),
                    "lower" => round($bollinger[2][19], 2),
                    "bb_signal" => $signals[1]["bb_signal"]
                ],
                "macd" => [
                    "macd" => round(end($macd_signal_divergence[0]), 2),
                    "signal" => round(end($macd_signal_divergence[1]), 2),
                    "divergence" => round(end($macd_signal_divergence[2]), 2),
                    "macd_signal" => $signals[3]["macd_signal"]
                ],
                "rsi" => [
                    "rsi_14" => round(end($rsi_14), 2),
                    "rsi_28" => round(end($rsi_28), 2),
                    "rsi_42" => round(end($rsi_42), 2),
                    "rsi_signal" => $signals[2]["rsi_signal"]
                ],
                "stochastic_fast" => [
                    "stochastic_d" => round(end($stochastic[1]), 2),
                    "stochastic_k" => round(end($stochastic[0]), 2),
                    "stochastic_fast_signal" => $signals[4]["stochastic_fast_signal"]
                ],
                "trend" => round($trend[0], 4),
                "close" => round($current_quote["close"], 2),

                "metadata" => [
                    "status" => 200,
                    "count" => 1,
                    "endpoint" => "http://bracketorder.com/api/bracketorder",
                    "method" => "GET",
                    "format" => "JSON",
                    "description" => ""
                ]
            ];

//            return $adjusted_close_dec;
            return $technicals;
        });

        $json = json_encode($technicals);

        $array = json_decode($json, true);

        if (Cache::has('bracket_order_' . $request->input('ticker_symbol')) && array_key_exists('original', $array)) {
            return response()->json($technicals->original, 200);
        } else {
            return response()->json($technicals, 200);
        }
    }
}
