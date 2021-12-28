<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Mobile_Detect;
use SimpleXMLElement;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getTopNews()
    {
        $news = Controller::news();

        // dd($news);

        $detect = new Mobile_Detect;

        if ($detect->isMobile() == true) {
            return view('mobile/partials/news/index', compact('news'));
        } else {
            return view('mobile/partials/news/index', compact('news'));
        }
    }

    public function getNewsArticle(Request $request)
    {
        $articles = Controller::news();

        $story = [];

        foreach($articles as $article) {
            if($article['article_id'] == $request->input('article_id')) {
                array_push(
                    $story, [
                        'article_id' => $article['article_id'],
                        'title' => $article['title'],
                        'full_title' => $article['full_title'],
                        'news_url' => $article["news_url"],
                        'image_url' => $article['image_url'],
                        'author' => $article["author"],
                        'text' => str_replace("\n", "</p><br><p>", $article["text"]),
                        'source_name' => $article['source_name'],
                        'date' => $article["date"],
                        'time_passed' => $article['time_passed']           
                    ]
                );
            }
        }
        $story = $story[0];
        return view('mobile/partials/news/article', compact('story'));
    }

    public function getTechnologyNews()
    {

        $yahoo_rss_base_url = "http://feeds.reuters.com/reuters/technologyNews";

        $rss = curl_init($yahoo_rss_base_url);
        curl_setopt($rss, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Connection: Keep-Alive'));
        curl_setopt($rss, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($rss, CURLOPT_RETURNTRANSFER, true);

        $curl_rss = curl_exec($rss);

        $yahoo_xml = new SimpleXMLElement($curl_rss);

        $yahoo_array = json_decode(json_encode($yahoo_xml, true));

        $stories = $yahoo_array->channel->item;

        $copyright = "Copyright (c) 2018 Reuters. All rights reserved.";

        $news = [];

        foreach ($stories as $story) {
            $description = explode('<div class="feedflare">', $story->description);

            array_push(
                $news, [
                    'title' => str_replace("[$$] ", "", $story->title),
                    'description' => $description[0],
                    'link' => $story->link,
                    'date' => $story->pubDate,
                    'copyright' => $copyright,
                    'guid' => $story->guid
                ]
            );
        }

        usort($news, function($a, $b) {
            if((strtotime($a['date']) * 1000) == (strtotime($b['date']) * 1000)) {
                return 0;
            } else {
                return (strtotime($a['date']) * 1000) < (strtotime($b['date']) * 1000) ? 1 : -1;
            }
        });

        $detect = new Mobile_Detect;

        if($detect->isTablet() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } elseif($detect->isMobile() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } else {
            return view('desktop/account/news/top-news', compact('news'));
        }

        return view('tablet/account/news/technology', compact('news'));
    }

    public function getUSNews()
    {

        $yahoo_rss_base_url = "http://feeds.reuters.com/Reuters/domesticNews";

        $rss = curl_init($yahoo_rss_base_url);
        curl_setopt($rss, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Connection: Keep-Alive'));
        curl_setopt($rss, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($rss, CURLOPT_RETURNTRANSFER, true);

        $curl_rss = curl_exec($rss);

        $yahoo_xml = new SimpleXMLElement($curl_rss);

        $yahoo_array = json_decode(json_encode($yahoo_xml, true));

        $stories = $yahoo_array->channel->item;

        $copyright = "Copyright (c) 2018 Reuters. All rights reserved.";

        $news = [];

        foreach ($stories as $story) {
            $description = explode('<div class="feedflare">', $story->description);

            array_push(
                $news, [
                    'title' => str_replace("[$$] ", "", $story->title),
                    'description' => $description[0],
                    'link' => $story->link,
                    'date' => $story->pubDate,
                    'copyright' => $copyright,
                    'guid' => $story->guid
                ]
            );
        }

        usort($news, function($a, $b) {
            if((strtotime($a['date']) * 1000) == (strtotime($b['date']) * 1000)) {
                return 0;
            } else {
                return (strtotime($a['date']) * 1000) < (strtotime($b['date']) * 1000) ? 1 : -1;
            }
        });

        $detect = new Mobile_Detect;

        if($detect->isTablet() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } elseif($detect->isMobile() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } else {
            return view('desktop/account/news/top-news', compact('news'));
        }

        return view('tablet/account/news/us-news', compact('news'));
    }

    public function getWorldNews()
    {

        $yahoo_rss_base_url = "http://feeds.reuters.com/Reuters/worldNews";

        $rss = curl_init($yahoo_rss_base_url);
        curl_setopt($rss, CURLOPT_HTTPHEADER, array('Content-Type: application/xml','Connection: Keep-Alive'));
        curl_setopt($rss, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($rss, CURLOPT_RETURNTRANSFER, true);

        $curl_rss = curl_exec($rss);

        $yahoo_xml = new SimpleXMLElement($curl_rss);

        $yahoo_array = json_decode(json_encode($yahoo_xml, true));

        $stories = $yahoo_array->channel->item;

        $copyright = "Copyright (c) 2018 Reuters. All rights reserved.";

        $news = [];

        foreach ($stories as $story) {
            $description = explode('<div class="feedflare">', $story->description);

            array_push(
                $news, [
                    'title' => str_replace("[$$] ", "", $story->title),
                    'description' => $description[0],
                    'link' => $story->link,
                    'date' => $story->pubDate,
                    'copyright' => $copyright,
                    'guid' => $story->guid
                ]
            );
        }

        usort($news, function($a, $b) {
            if((strtotime($a['date']) * 1000) == (strtotime($b['date']) * 1000)) {
                return 0;
            } else {
                return (strtotime($a['date']) * 1000) < (strtotime($b['date']) * 1000) ? 1 : -1;
            }
        });

        $detect = new Mobile_Detect;

        if($detect->isTablet() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } elseif($detect->isMobile() == true) {
            return view('tablet/account/news/top-news', compact('news'));
        } else {
            return view('desktop/account/news/top-news', compact('news'));
        }

        return view('tablet/account/news/world', compact('news'));
    }
}
