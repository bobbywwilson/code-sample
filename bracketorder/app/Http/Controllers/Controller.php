<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function news() {
        Cache::flush();
        $news = Cache::rememberForever('news', function () {
            // $news_base = "https://stocknewsapi.com/api/v1?tickers=aapl&items=10&fallback=true&token=vmyri84nwu9jtlxuwwxdzvlgiydiyakke7pxynem";

            $news_base = "http://webhose.io/filterWebContent?token=cc794479-2906-4e75-80dc-0f854e218a5b&format=json&sort=relevancy&q=" ;
            $ticker_symbol = "aapl" ;
            $parameters = "%20language%3Aenglish%20site_type%3Anews%20(site%3Acnbc.com%20OR%20site%3Areuters.com%20OR%20site%3Afool.com%20OR%20site%3Acnet.com%20OR%20site%3Afobes.com%20OR%20site%3Azacks.com%20OR%20site%3Abloomberg.com)";

            $news_url = $news_base . $ticker_symbol . $parameters;

            $news = curl_init($news_url);
            curl_setopt($news, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Connection: Keep-Alive'));
            curl_setopt($news, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
            curl_setopt($news, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($history, CURLOPT_SSL_VERIFYPEER, 0);

            $stories_json = curl_exec($news);

            $stories = json_decode($stories_json, true);

            $news = [];

            foreach ($stories["posts"] as $story) {
                if($story['thread']['main_image'] != "") {
                    array_push(
                        $news, [
                            'article_id' => $story['thread']['uuid'],
                            'title' => $story['thread']["title"],
                            'full_title' => $story['thread']["title_full"],
                            'news_url' => str_replace("http://", "https://", $story['thread']["url"]),
                            'image_url' => str_replace("http://", "https://", $story['thread']["main_image"]),
                            'author' => $story["author"],
                            'text' => $story["text"],
                            'source_name' => str_replace("www.", "", str_replace(".com", "", $story['thread']["site_full"])),
                            'date' => $story["published"],
                            'time_passed' => Carbon::createFromTimeStamp(strtotime($story['published']))->subHours(4)->diffForHumans()                    
                        ]
                    );
                }
            }

            usort($news, function ($a, $b) {
                if ((strtotime($a['date']) * 1000) == (strtotime($b['date']) * 1000)) {
                    return 0;
                } else {
                    return (strtotime($a['date']) * 1000) < (strtotime($b['date']) * 1000) ? 1 : -1;
                }
            });

            return $news;
        });

        return $news;
    }
}
