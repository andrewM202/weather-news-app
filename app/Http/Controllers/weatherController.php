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
}
