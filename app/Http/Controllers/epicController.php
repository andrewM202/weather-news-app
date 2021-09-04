<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class epicController extends Controller
{
    public function index() {

        // returning vars with compact method
        $title = "Welcome!";

        $city_name = 'Lancaster';
        $weather_api_key = env('OPENWEATHER_API_KEY=');
        $api_url = 'http://api.openweathermap.org/data/2.5/weather?&units=imperial&q='.$city_name.'&appid='.$weather_api_key;
        // If the city name is invalid and API call fails, throw an error
        try {
            file_get_contents($api_url);
        } catch(\Throwable $e) {
            return view('baseview')->with('data', [
                'Error' => 'Invalid City Name'
            ]);
        }
        $weather_data = json_decode(file_get_contents($api_url), true);



        // Set hours to shift from UTC
        $hours_to_adjust = ($weather_data['timezone']);

        // Get location in variable
        $location = $weather_data['name'].", ".$weather_data['sys']['country']." <br>".date("m/d/Y, g:i:s A", (time()+$hours_to_adjust));

        // Get mass content of weather in array
        $data = [
            'temp' => "Temperature: ".(string)$weather_data['main']['temp']." Fahrenheit",
            'humidity' => "Humidity: ".(string)$weather_data['main']['humidity']."%",
            'wind_speed' => "Wind Speed: ".$weather_data['wind']['speed']." m/h",
            'pressure' => "Pressure: ".(string)$weather_data['main']['pressure']." hPa",
            'weather_desc' => "Weather: ".ucwords($weather_data['weather']['0']['description'], ' '),
            'sunset' => "Sunset: ".date("g:i:s A", $weather_data['sys']['sunset']+$hours_to_adjust),
            'sunrise' => "Sunrise: ".date("g:i:s A", $weather_data['sys']['sunrise']+$hours_to_adjust),
            'clouds' => "Percent Clouds: ".(string)$weather_data['clouds']['all']."%"
        ];


        // Chaining variable returns with ->with method 
        return view('baseview')->with('data', $data)->with('location', $location);

        // returning multiple vars/array with "with" method
        // $data = [
        //     'title' => $title,
        //     'box1' => $box1
        // ];
        // return view('baseview')->with('data', $data);
    }

    public function printroutetest() {
        // Print out the url
        print_r(route('test'));
        echo "<br>";
        // doesnt work but basically do same thing but in html
        print_r("<a href='{{ route('test') }} '>Test</a>");
    }

    public function weather($city) {
        // return the weather for a specific city
        $city_name = $city;
        $weather_api_key = env('OPENWEATHER_API_KEY=');
        $api_url = 'http://api.openweathermap.org/data/2.5/weather?&units=imperial&q='.$city_name.'&appid='.$weather_api_key;
        // If the city name is invalid and API call fails, throw an error
        try {
            file_get_contents($api_url);
        } catch(\Throwable $e) {
            return view('baseview')->with('data', [
                'Error' => 'Invalid City Name'
            ]);
        }
        $weather_data = json_decode(file_get_contents($api_url), true);

        // Build iframe with geolocation
        $lon = $weather_data['coord']['lon'];
        $lat = $weather_data['coord']['lat'];

        // Set hours to shift from UTC
        $hours_to_adjust = ($weather_data['timezone']);

        // Get location in variable
        $location = $weather_data['name'].", ".$weather_data['sys']['country']." <br>".date("m/d/Y, g:i:s A", (time()+$hours_to_adjust));

        $data = [
            'temp' => "Temperature: ".(string)$weather_data['main']['temp']." Fahrenheit",
            'humidity' => "Humidity: ".(string)$weather_data['main']['humidity']."%",
            'wind_speed' => "Wind Speed: ".$weather_data['wind']['speed']." mph",
            'pressure' => "Pressure: ".(string)$weather_data['main']['pressure']." hPa",
            'weather_desc' => "Weather: ".ucwords($weather_data['weather']['0']['description'], ' '),
            'sunset' => "Sunset: ".date("g:i:s A", $weather_data['sys']['sunset']+$hours_to_adjust),
            'sunrise' => "Sunrise: ".date("g:i:s A", $weather_data['sys']['sunrise']+$hours_to_adjust),
            'clouds' => "Percent Clouds: ".(string)$weather_data['clouds']['all']."%"
        ];

        // returning a single var with "with" method 
        return view('baseview')->with('data', $data)->with('location', $location);
    }
}
