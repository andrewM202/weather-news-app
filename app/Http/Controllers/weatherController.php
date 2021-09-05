<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class weatherController extends Controller
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
