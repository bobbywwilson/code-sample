<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NumberFormatter;

class FundamentalsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getProfile(Request $request)
    {
        if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
            $ticker_symbol = $request->input('ticker_symbol');
        } else {
            $ticker_symbol = str_replace(" - ", "", substr($request->input("ticker_symbol"), 0, 10));
        }

        $ticker_symbol = strtolower(trim($ticker_symbol));

        if(strtoupper(substr($ticker_symbol, -5, 5)) != ".INDX") {
            // $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
            // $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

            $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;

            $get_fundamentals = curl_init($fundamentals_url);
            curl_setopt($get_fundamentals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
            curl_setopt($get_fundamentals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($get_fundamentals, CURLOPT_RETURNTRANSFER, true);

            $curl_fundamentals = curl_exec($get_fundamentals);

            $fundamentals = json_decode($curl_fundamentals, true);

            return view('desktop/partials/profile/index', compact('fundamentals', 'percentFormat', 'currencyFormat'));
        }

        return view('desktop/partials/profile/index');
    }
}
