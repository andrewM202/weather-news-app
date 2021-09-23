<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class apiTestController extends Controller
{
    public function weatherData() {
        $city_name = 'Lancaster';
        $api_key = env('OPENWEATHER_API_KEY');
        $api_url = 'https://api.openweathermap.org/data/2.5/weather?&units=imperial&q='.$city_name.'&appid='.$api_key;
        $weather_data = json_decode(file_get_contents($api_url), true);

        // return $temperature;
        return '<pre>'.print_r($weather_data, true).'</pre>';
    }

    public function pollutionData() {
        $api_key = env('OPENWEATHER_API_KEY');
        $lat = 40.2504;
        $lon = -76.2499;
        $api_url = 'http://api.openweathermap.org/data/2.5/air_pollution?lat='.$lat.'&lon='.$lon.'&appid='.$api_key;
        $pollution_data = json_decode(file_get_contents($api_url), true);

        return '<pre>'.print_r($pollution_data, true).'</pre>';
    }

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

    public function restCountryData() {
        $country = 'us';
        $country_api_raw = json_decode(file_get_contents('https://restcountries.com/v3/alpha/'.$country), true);
        return '<pre>'.print_r($country_api_raw, true).'</pre>';   
    }

    public function maps() {
        $api_key = env('OPENWEATHER_API_KEY');
        $x = 1;
        $y = 1;
        $z = 1;
        $layer = 'SD0';
        $api_url = 'https://maps.openweathermap.org/maps/2.0/weather/1h/HRD0/4/1/6?date=1618898990&appid='.$api_key;
        // $map_data = json_decode(file_get_contents($api_url), true);
        return '<pre><iframe style="
        width: 500px;
        height: 500px;
        " src="'.$api_url.'"></iframe></pre>';
    }
}
