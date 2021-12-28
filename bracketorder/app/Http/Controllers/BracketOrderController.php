<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DOMDocument;
use Exception;
use Illuminate\Http\Request;
use Mobile_Detect;
use NumberFormatter;
use SimpleXMLElement;

class BracketOrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function bracketOrder(Request $request)
    {
        $ticker_symbol = str_replace('"', "", strtolower(trim($request->input("ticker_symbol"))));

        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $bracket_order = "https://bracketorder.com/bracketorder-api/api/bracketorder?ticker_symbol=" . $ticker_symbol;
        $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $ticker_symbol;
        $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;

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

        if (array_key_exists('original', $quote_array)) {
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

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/bracketorder/index', compact('bracket', 'quote', 'fundamentals', 'percentFormat', 'currencyFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/bracketorder/index', compact('bracket', 'quote', 'fundamentals', 'percentFormat', 'currencyFormat'));
        } else {
            return view('desktop/partials/bracketorder/index', compact('bracket', 'quote', 'fundamentals', 'percentFormat', 'currencyFormat'));
        }
    }

    public function getQuote(Request $request)
    {
        $ticker_symbol = strtolower(trim($request->input('ticker_symbol')));

        // $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        // $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;

        $get_fundamentals = curl_init($fundamentals_url);
        curl_setopt($get_fundamentals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_fundamentals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_fundamentals, CURLOPT_RETURNTRANSFER, true);

        $curl_fundamentals = curl_exec($get_fundamentals);

        $fundamentals = json_decode($curl_fundamentals, true);

        $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $ticker_symbol;

        $get_quote = curl_init($stock_url);
        curl_setopt($get_quote, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_quote, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_quote, CURLOPT_RETURNTRANSFER, true);

        $curl_quote = curl_exec($get_quote);

        $quote_array = json_decode($curl_quote, true);

        if (array_key_exists('original', $quote_array)) {
            $quote = $quote_array['original'][0];
        } else {
            $quote = $quote_array[0];
        }

        $market_open = [];

        if(date("H:i", strtotime(Carbon::now())) >= "0930" && date("H:i", strtotime(Carbon::now())) <= "1605") {
            array_push($market_open, "open");
        } else {
            array_push($market_open, "closed");
        }

        $session = $market_open[0];

        if(strtoupper(substr($ticker_symbol, -5, 5)) == ".INDX") {
            $name = $fundamentals[0]["Name"];
        } else {
            $name = $fundamentals["General"]["Name"];
        }

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/stock/stock-quote', compact('name', 'quote', 'session', 'percentFormat', 'currencyFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/stock/stock-quote', compact('name', 'quote', 'session', 'percentFormat', 'currencyFormat'));
        } else {
            return view('desktop/partials/stock/stock-quote', compact('name', 'quote', 'session', 'percentFormat', 'currencyFormat'));
        }
    }

    public function getNews(Request $request)
    {
        if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
            $ticker_symbol = $request->input('ticker_symbol');
        } else {
            $ticker_symbol = str_replace(" - ", "", substr($request->input("ticker_symbol"), 0, 10));
        }

        $ticker_symbol = explode(".", strtolower(trim($ticker_symbol)));

        $ticker_symbol = $ticker_symbol[0];

//        $yahoo_rss_base_url = "https://feeds.finance.yahoo.com/rss/2.0/headline?s=" . $ticker_symbol;

        $nasdaq_rss_base_url = "http://articlefeeds.nasdaq.com/nasdaq/symbols?symbol=" . $ticker_symbol;

        $rss = curl_init($nasdaq_rss_base_url);
        curl_setopt($rss, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Connection: Keep-Alive'));
        curl_setopt($rss, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($rss, CURLOPT_RETURNTRANSFER, true);

        $curl_rss = curl_exec($rss);

        $news_xml = new SimpleXMLElement($curl_rss);

        $news_array = json_decode(json_encode($news_xml, true));

        $news = [];

        try {
            $stories = $news_array->channel->item;

            $copyright = "Copyright (c) " . date("Y") . " Nasdaq. All rights reserved.";

            foreach ($stories as $story) {
                array_push(
                    $news, [
                        'title' => $story->title,
                        'description' => $story->description,
                        'link' => $story->link,
                        'date' => $story->pubDate,
                        'copyright' => $copyright,
                        'guid' => $story->guid
                    ]
                );
            }
        } catch (Exception $e) {

        }

        $detect = new Mobile_Detect;

        if($detect->isTablet() == true) {
            return view('desktop/partials/news/index', compact('news'));
        } elseif($detect->isMobile() == true) {
            return view('mobile/partials/news/index', compact('news'));
        } else {
            return view('desktop/partials/news/index', compact('news'));
        }
    }
}
