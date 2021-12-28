<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mobile_Detect;
use NumberFormatter;

class TechnicalsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTechnicals(Request $request)
    {
        if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
            $ticker_symbol = $request->input('ticker_symbol');
        } else {
            $ticker_symbol = str_replace(" - ", "", substr($request->input("ticker_symbol"), 0, 10));
        }

        $ticker_symbol = strtolower(trim($ticker_symbol));

        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $bracket_order = "https://bracketorder.com/bracketorder-api/api/bracketorder?ticker_symbol=" . $ticker_symbol;
        $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $ticker_symbol;
        $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;
        $technicals_url = "https://bracketorder.com/bracketorder-api/api/technicals?ticker_symbol=" . $ticker_symbol;

        $get_bracket = curl_init($bracket_order);
        curl_setopt($get_bracket, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_bracket, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_bracket, CURLOPT_RETURNTRANSFER, true);

        $curl_bracket = curl_exec($get_bracket);

        $bracket = json_decode($curl_bracket, true);

        $get_quote = curl_init($stock_url);
        curl_setopt($get_quote, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_quote, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_quote, CURLOPT_RETURNTRANSFER, true);

        $curl_quote = curl_exec($get_quote);

        $quote_array = json_decode($curl_quote, true);

        if (array_key_exists("original", $quote_array)) {
            $quote = $quote_array["original"][0];
        } else {
            $quote = $quote_array[0];
        }

        $get_fundamentals = curl_init($fundamentals_url);
        curl_setopt($get_fundamentals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_fundamentals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_fundamentals, CURLOPT_RETURNTRANSFER, true);

        $curl_fundamentals = curl_exec($get_fundamentals);

        $fundamentals = json_decode($curl_fundamentals, true);

        $get_technicals = curl_init($technicals_url);
        curl_setopt($get_technicals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_technicals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_technicals, CURLOPT_RETURNTRANSFER, true);

        $curl_technicals = curl_exec($get_technicals);

        $technicals = json_decode($curl_technicals, true);

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('mobile/partials/technicals/index', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/technicals/index', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        } else {
            return view('mobile/partials/technicals/index', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        }
    }

    public function MarketTechnicals(Request $request)
    {
        if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
            $ticker_symbol = $request->input('ticker_symbol');
        } else {
            $ticker_symbol = str_replace(" - ", "", substr($request->input("ticker_symbol"), 0, 10));
        }

        $ticker_symbol = strtolower(trim($ticker_symbol));

        // $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        // $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $bracket_order = "https://bracketorder.com/bracketorder-api/api/bracketorder?ticker_symbol=" . $ticker_symbol;
        $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $ticker_symbol;
        $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;
        $technicals_url = "https://bracketorder.com/bracketorder-api/api/technicals?ticker_symbol=" . $ticker_symbol;

        $get_bracket = curl_init($bracket_order);
        curl_setopt($get_bracket, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_bracket, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_bracket, CURLOPT_RETURNTRANSFER, true);

        $curl_bracket = curl_exec($get_bracket);

        $bracket = json_decode($curl_bracket, true);

        $get_quote = curl_init($stock_url);
        curl_setopt($get_quote, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_quote, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_quote, CURLOPT_RETURNTRANSFER, true);

        $curl_quote = curl_exec($get_quote);

        $quote_array = json_decode($curl_quote, true);

        $quote = $quote_array[0];

        $get_fundamentals = curl_init($fundamentals_url);
        curl_setopt($get_fundamentals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_fundamentals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_fundamentals, CURLOPT_RETURNTRANSFER, true);

        $curl_fundamentals = curl_exec($get_fundamentals);

        $fundamentals = json_decode($curl_fundamentals, true);

        $get_technicals = curl_init($technicals_url);
        curl_setopt($get_technicals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_technicals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_technicals, CURLOPT_RETURNTRANSFER, true);

        $curl_technicals = curl_exec($get_technicals);

        $technicals = json_decode($curl_technicals, true);

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/market/market-technicals', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/market/market-technicals', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        } else {
            return view('desktop/partials/market/market-technicals', compact('bracket', 'quote', 'fundamentals', 'technicals', 'percentFormat', 'currencyFormat'));
        }
    }
}
