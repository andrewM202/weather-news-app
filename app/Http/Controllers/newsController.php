<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class newsController extends Controller
{
    public function newsData() {
        // Get content for news 
        $news_api_key = env('NEWS1_API_KEY');
        $country_name = 'US';
        $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.$country_name.'&apiKey='.$news_api_key;

        // json_decode formats the JSON nicely 
        $news_data = json_decode(file_get_contents($news_api_url));
        // Return news JSON
        return '<pre>'.print_r($news_data, true).'</pre>';
    }
}
