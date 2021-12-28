<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Mobile_Detect;
use NumberFormatter;
use Cookie;

class AccountController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(Cache::get('news'));
        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);

        $markets_url = "https://bracketorder.com/bracketorder-api/api/markets";

        $get_markets = curl_init($markets_url);
        curl_setopt($get_markets, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_markets, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_markets, CURLOPT_RETURNTRANSFER, true);

        $curl_markets = curl_exec($get_markets);

        $markets_array = json_decode($curl_markets, true);

        $markets = $markets_array["markets"];

        $detect = new Mobile_Detect;

        if($detect->isTablet() == true) {
            return view('tablet/account/index', compact('markets', 'percentFormat'));
        //    return view('desktop/account/index', compact('markets', 'percentFormat'));
        } elseif($detect->isMobile() == true) {
            return view('mobile/account/index', compact('markets', 'percentFormat'));
        } else {
            return view('desktop/account/index', compact('markets', 'percentFormat'));
            // return view('desktop/account/index', compact('markets', 'percentFormat'));
        }
    }

    public function marketQuote()
    {
        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);

        $markets_url = "https://bracketorder.com/bracketorder-api/api/markets";

        $get_markets = curl_init($markets_url);
        curl_setopt($get_markets, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_markets, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_markets, CURLOPT_RETURNTRANSFER, true);

        $curl_response = curl_exec($get_markets);

        $markets_array = json_decode($curl_response, true);

        $markets = $markets_array["markets"];

        $market_open = [];

        if(date("H:i", strtotime(Carbon::now())) >= "0930" && date("H:i", strtotime(Carbon::now())) <= "1605") {
            array_push($market_open, "open");
        } else {
            array_push($market_open, "closed");
        }

        $session = $market_open[0];

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/market/market-quote', compact('markets', 'session', 'percentFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/market/market-quote', compact('markets', 'session', 'percentFormat'));
        } else {
            return view('desktop/partials/market/market-quote', compact('markets', 'session', 'percentFormat'));
        }

    }
}
