<?php

namespace App\Http\Controllers;

use App\Watchlist;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mobile_Detect;
use NumberFormatter;

class WatchlistController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addWatchlistButton(Request $request)
    {
        if(substr($request->input("ticker_symbol"), -5, 5) == ".indx") {
            $ticker_symbol = $request->input('ticker_symbol');
        } else {
            $ticker_symbol = str_replace(" - ", "", substr($request->input("ticker_symbol"), 0, 10));
        }

        $ticker_symbol = strtolower(trim($ticker_symbol));

        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $fundamentals_url = "https://bracketorder.com/bracketorder-api/api/fundamentals?ticker_symbol=" . $ticker_symbol;
        $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $ticker_symbol;

        $get_fundamentals = curl_init($fundamentals_url);
        curl_setopt($get_fundamentals, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Connection: Keep-Alive'));
        curl_setopt($get_fundamentals, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($get_fundamentals, CURLOPT_RETURNTRANSFER, true);

        $curl_fundamentals = curl_exec($get_fundamentals);

        $fundamentals = json_decode($curl_fundamentals, true);

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

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/watchlist/watchlist-button', compact('fundamentals', 'quote', 'percentFormat', 'currencyFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/watchlist/watchlist-button', compact('fundamentals', 'quote', 'percentFormat', 'currencyFormat'));
        } else {
            return view('desktop/partials/watchlist/watchlist-button', compact('fundamentals', 'quote', 'percentFormat', 'currencyFormat'));
        }

    }

    public function addToWatchlist(Request $request)
    {
        $watchlist = new Watchlist();

        $watchlist->user_id = $request->input('user_id');
        $watchlist->sector = substr($request->input("ticker_symbol"), -5, 5) == ".INDX" ? "Index" : $request->input('sector');
        $watchlist->ticker_symbol = $request->input('ticker_symbol');

        $watchlists = DB::table('watchlists')
            ->where('user_id', '=', $request->input('user_id'))
            ->get();

        $duplicate = false;

        foreach ($watchlists as $watchlist_item) {
            if($watchlist_item->ticker_symbol == $request->input('ticker_symbol')) {
                $duplicate = true;
            }
        }

        if ($duplicate == false) {
            try {
                $watchlist->save();
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    }

    public function showWatchlist(Request $request)
    {
        $percentFormat = new NumberFormatter('en_US', NumberFormatter::PERCENT);
        $currencyFormat = new NumberFormatter('en_US', NumberFormatter::CURRENCY);

        $watchlist = DB::table('watchlists')
            ->where('user_id', '=', $request->input('user_id'))
            ->get();

        $quotes = [];

        if($watchlist->isNotEmpty()) {
            $ticker_symbols = [];

            foreach ($watchlist as $item) {
                array_push($ticker_symbols, $item->ticker_symbol);
            }

            $symbols = str_replace("\"", "", str_replace("]", "", str_replace("[", "", json_encode($ticker_symbols))));

            $stock_url = "https://bracketorder.com/bracketorder-api/api/quote?ticker_symbol=" . $symbols;

            $get_quote = curl_init($stock_url);
            curl_setopt($get_quote, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Connection: Keep-Alive'));
            curl_setopt($get_quote, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($get_quote, CURLOPT_RETURNTRANSFER, true);

            $curl_quote = curl_exec($get_quote);

            $quote = json_decode($curl_quote, true);

            if (array_key_exists('original', $quote)) {
                $quote = $quote["original"];
            }
//            else {
//                $quote = $quote[0];
//            }

            foreach ($quote as $item) {
                array_push($quotes,
                    [
                        'ticker_symbol' => $item['code'],
                        'previousClose' => $item['previousClose'],
                        'change' => $item['change'],
                        'close' => $item['close'],
                        'timestamp' => $item['timestamp']
                    ]
                );
            }
        }

        $market_open = [];

        if(date("l", strtotime(Carbon::now())) != "Saturday" && date("l", strtotime(Carbon::now())) != "Sunday" && date("H:i", strtotime(Carbon::now())) >= "0930" && date("H:i", strtotime(Carbon::now())) <= "1605") {
            array_push($market_open, "open");
        } else {
            array_push($market_open, "closed");
        }

        $session = $market_open[0];

        $i = 0;

        $detect = new Mobile_Detect;

        if($detect->isTablet()) {
            return view('desktop/partials/watchlist/index', compact('fundamentals', 'i', 'watchlist', 'session', 'quotes', 'currencyFormat', 'percentFormat'));
        } elseif($detect->isMobile()) {
            return view('mobile/partials/watchlist/index', compact('fundamentals', 'i', 'watchlist', 'session', 'quotes', 'currencyFormat', 'percentFormat'));
        } else {
            return view('desktop/partials/watchlist/index', compact('fundamentals', 'i', 'watchlist', 'session', 'quotes', 'currencyFormat', 'percentFormat'));
        }
    }

    public function DeleteWatchlist(Request $request)
    {
        $stock = Watchlist::find($request->input('id'));

        if (!empty($stock)) {
            try {
                $stock->delete($request->input('id'));
            } catch (Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }
    }
}
