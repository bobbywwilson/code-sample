<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use stdClass;

class BracketOrderController extends Controller
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
    public function getBracket(Request $request)
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @internal param $ticker_symbol
     * @internal param $from
     * @internal param $to
     */
    public function getQuote(Request $request)
    {
//        Cache::flush();
        $quote = Cache::remember('quote_' . $request->input("ticker_symbol"), 25, function () use ($request) {

            $current_quote = Controller::currentQuote($request);

            $quote = [];

            $ticker_symbols = count(explode(",", $request->input('ticker_symbol')));

            if($ticker_symbols > 1) {
                foreach ($current_quote as $item) {
                    array_push($quote,
                        [
                            "code" => $item["code"],
                            "timestamp" => $item['timestamp'],
                            "open" => $item['open'],
                            "high" => $item['high'],
                            "low" => $item['low'],
                            "close" => $item['close'],
                            "volume" => $item['volume'],
                            "previousClose" => $item['previousClose'],
                            "change" => $item['change']
                        ]
                    );
                }
            } else {
                array_push($quote,
                    [
                        "code" => $current_quote['code'],
                        "timestamp" => $current_quote['timestamp'],
                        "open" => $current_quote['open'],
                        "high" => $current_quote['high'],
                        "low" => $current_quote['low'],
                        "close" => $current_quote['close'],
                        "volume" => $current_quote['volume'],
                        "previousClose" => $current_quote['previousClose'],
                        "change" => $current_quote['change']
                    ]
                );
            }

            return response()->json($quote, 200);
        });

        $json = json_encode($quote);

        $array = json_decode($json, true);

        if (Cache::has('bracket_order_' . $request->input('ticker_symbol')) && array_key_exists('original', $array)) {
            return response()->json($quote->original, 200);
        } else {
            return response()->json($quote, 200);
        }
    }

    public function getSymbols()
    {
        Cache::flush();
        $select_symbols = Cache::rememberForever('select_symbols', function () {
            $symbols = Controller::symbols();

            $symbol_array = array();

            for ($i = 0; $i < count($symbols); $i++) {
                foreach ($symbols[$i] as $symbol) {
                    $results = array('items' => array('ticker_symbol' => $symbol['Code'], 'exchange' => $symbol['Exchange'], 'company_name' => $symbol['Name'], 'sector' => $symbol['Sector'], 'industry' => $symbol['Industry']));

                    foreach ($results as $result) {
                        $symbol_array_items["id"] = $result["ticker_symbol"];
                        $symbol_array_items["exchange"] = $result["exchange"];
                        $symbol_array_items["company_name"] = $result["company_name"];
                        $symbol_array_items["sector"] = $result["sector"];
                        $symbol_array_items["industry"] = $result["industry"];
                        $symbol_array_items["text"] = $result["ticker_symbol"] . ".US - " . $result["company_name"];
                        $symbol_array[] = $symbol_array_items;
                    }
                }
            }

            return response()->json($symbol_array, 200);
        });

        return $select_symbols;
    }
}
