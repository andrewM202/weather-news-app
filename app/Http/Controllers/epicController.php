<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class epicController extends Controller
{
    public function index() {

        // returning vars with compact method
        $title = "Welcome!";

        $city_name = 'Lancaster';
        $weather_api_key = env('OPENWEATHER_API_KEY');
        $weather_api_url = 'http://api.openweathermap.org/data/2.5/weather?&units=imperial&q='.$city_name.'&appid='.$weather_api_key;

        // If the city name is invalid and API call fails, throw an error
        try {
            file_get_contents($weather_api_url);
        } catch(\Throwable $e) {
            return view('baseview')->with('data', [
                'Error' => 'Invalid City Name'
            ]);
        }
        $weather_data_raw = json_decode(file_get_contents($weather_api_url), true);

        // Build iframe with geolocation
        $lon = $weather_data_raw['coord']['lon'];
        $lat = $weather_data_raw['coord']['lat'];

        // Set hours to shift from UTC
        $hours_to_adjust = ($weather_data_raw['timezone']);

        // Get location in variable
        $location = $weather_data_raw['name'].", ".$weather_data_raw['sys']['country']." <br>".date("m/d/Y, g:i:s A", (time()+$hours_to_adjust));

        // Get mass content of weather in array
        $weather_data = [
            'temp' => "Temperature: ".(string)$weather_data_raw['main']['temp']." Fahrenheit",
            'feels' => "Feels Like: ".(string)$weather_data_raw['main']['feels_like']." Fahrenheit",
            'humidity' => "Humidity: ".(string)$weather_data_raw['main']['humidity']."%",
            'wind_speed' => "Wind Speed: ".$weather_data_raw['wind']['speed']." m/h",
            'pressure' => "Pressure: ".(string)$weather_data_raw['main']['pressure']." hPa",
            'weather_desc' => "Weather: ".ucwords($weather_data_raw['weather']['0']['description'], ' '),
            'sunset' => "Sunset: ".date("g:i:s A", $weather_data_raw['sys']['sunset']+$hours_to_adjust),
            'sunrise' => "Sunrise: ".date("g:i:s A", $weather_data_raw['sys']['sunrise']+$hours_to_adjust),
            'clouds' => "Cloud Cover: ".(string)$weather_data_raw['clouds']['all']."%"
        ];

        // Get content for news 
        $news_api_key = env('NEWS_API_KEY');
        //$news_api_url = 'https://newsapi.org/v2/top-headlines?country=us&apiKey=API_KEY';
        $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.$weather_data_raw['sys']['country'].'&apiKey='.$news_api_key;

        // if the country the weather api gives is bad, default to US
        try {
            $news_data_raw = json_decode(file_get_contents($news_api_url));
            $test = $news_data_raw->articles['0']->source->name;
        } catch (\Throwable $e) {
            $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.'us'.'&apiKey='.$news_api_key;
            $news_data_raw = json_decode(@file_get_contents($news_api_url));
        } finally {
            return view('baseview')
            ->with('weather_data', $weather_data)
            ->with('lon', $lon)
            ->with('lat', $lat)
            ->with('location', $location);
        }

        $news_data = [
            'name1' => $news_data_raw->articles['0']->source->name,
            'title1' => $news_data_raw->articles['0']->title,
            'image1' => $news_data_raw->articles['0']->urlToImage,
            'url1' => $news_data_raw->articles['0']->url,

            'name2' => $news_data_raw->articles['1']->source->name,
            'title2' => $news_data_raw->articles['1']->title,
            'image2' => $news_data_raw->articles['1']->urlToImage,
            'url2' => $news_data_raw->articles['1']->url,

            'name3' => $news_data_raw->articles['2']->source->name,
            'title3' => $news_data_raw->articles['2']->title,
            'image3' => $news_data_raw->articles['2']->urlToImage,
            'url3' => $news_data_raw->articles['2']->url,

            'name4' => $news_data_raw->articles['3']->source->name,
            'title4' => $news_data_raw->articles['3']->title,
            'image4' => $news_data_raw->articles['3']->urlToImage,
            'url4' => $news_data_raw->articles['3']->url,

            'name5' => $news_data_raw->articles['4']->source->name,
            'title5' => $news_data_raw->articles['4']->title,
            'image5' => $news_data_raw->articles['4']->urlToImage,
            'url5' => $news_data_raw->articles['4']->url,

            'name6' => $news_data_raw->articles['5']->source->name,
            'title6' => $news_data_raw->articles['5']->title,
            'image6' => $news_data_raw->articles['5']->urlToImage,
            'url6' => $news_data_raw->articles['5']->url,

            'name7' => $news_data_raw->articles['6']->source->name,
            'title7' => $news_data_raw->articles['6']->title,
            'image7' => $news_data_raw->articles['6']->urlToImage,
            'url7' => $news_data_raw->articles['6']->url,

            'name8' => $news_data_raw->articles['7']->source->name,
            'title8' => $news_data_raw->articles['7']->title,
            'image8' => $news_data_raw->articles['7']->urlToImage,
            'url8' => $news_data_raw->articles['7']->url
        ];

        // Chaining variable returns with ->with method 
        return view('baseview')
        ->with('weather_data', $weather_data)
        ->with('lon', $lon)
        ->with('lat', $lat)
        ->with('location', $location)
        ->with('news_data', $news_data);

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
        $weather_api_key = env('OPENWEATHER_API_KEY');
        $weather_api_url = 'http://api.openweathermap.org/data/2.5/weather?&units=imperial&q='.$city_name.'&appid='.$weather_api_key;
        // If the city name is invalid and API call fails, throw an error
        try {
            file_get_contents($weather_api_url);
        } catch(\Throwable $e) {
            return view('baseview')->with('data', [
                'Error' => 'Invalid City Name'
            ]);
        }
        $weather_data_raw = json_decode(file_get_contents($weather_api_url), true);

        // Build iframe with geolocation
        $lon = $weather_data_raw['coord']['lon'];
        $lat = $weather_data_raw['coord']['lat'];

        // Set hours to shift from UTC
        $hours_to_adjust = ($weather_data_raw['timezone']);

        // Get location in variable
        $location = $weather_data_raw['name'].", ".$weather_data_raw['sys']['country']." <br>".date("m/d/Y, g:i:s A", (time()+$hours_to_adjust));

        $weather_data = [
            'temp' => "Temperature: ".(string)$weather_data_raw['main']['temp']." Fahrenheit",
            'feels' => "Feels Like: ".(string)$weather_data_raw['main']['feels_like']." Fahrenheit",
            'humidity' => "Humidity: ".(string)$weather_data_raw['main']['humidity']."%",
            'wind_speed' => "Wind Speed: ".$weather_data_raw['wind']['speed']." mph",
            'pressure' => "Pressure: ".(string)$weather_data_raw['main']['pressure']." hPa",
            'weather_desc' => "Weather: ".ucwords($weather_data_raw['weather']['0']['description'], ' '),
            'sunset' => "Sunset: ".date("g:i:s A", $weather_data_raw['sys']['sunset']+$hours_to_adjust),
            'sunrise' => "Sunrise: ".date("g:i:s A", $weather_data_raw['sys']['sunrise']+$hours_to_adjust),
            'clouds' => "Cloud Cover: ".(string)$weather_data_raw['clouds']['all']."%"
        ];

        // Get content for news 
        $news_api_key = env('NEWS_API_KEY');
        $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.$weather_data_raw['sys']['country'].'&apiKey='.$news_api_key;

        // if the country the weather api gives is bad, default to US
        try {
            $news_data_raw = json_decode(file_get_contents($news_api_url));
        } catch (\Throwable $e) {
            $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.'us'.'&apiKey='.$news_api_key;
            $news_data_raw = json_decode(@file_get_contents($news_api_url));
        } finally {
            return view('baseview')
            ->with('weather_data', $weather_data)
            ->with('lon', $lon)
            ->with('lat', $lat)
            ->with('location', $location);
        }

        $news_data = [
            'name1' => $news_data_raw->articles['0']->source->name,
            'title1' => $news_data_raw->articles['0']->title,
            'image1' => $news_data_raw->articles['0']->urlToImage,
            'url1' => $news_data_raw->articles['0']->url,

            'name2' => $news_data_raw->articles['1']->source->name,
            'title2' => $news_data_raw->articles['1']->title,
            'image2' => $news_data_raw->articles['1']->urlToImage,
            'url2' => $news_data_raw->articles['1']->url,

            'name3' => $news_data_raw->articles['2']->source->name,
            'title3' => $news_data_raw->articles['2']->title,
            'image3' => $news_data_raw->articles['2']->urlToImage,
            'url3' => $news_data_raw->articles['2']->url,

            'name4' => $news_data_raw->articles['3']->source->name,
            'title4' => $news_data_raw->articles['3']->title,
            'image4' => $news_data_raw->articles['3']->urlToImage,
            'url4' => $news_data_raw->articles['3']->url,

            'name5' => $news_data_raw->articles['4']->source->name,
            'title5' => $news_data_raw->articles['4']->title,
            'image5' => $news_data_raw->articles['4']->urlToImage,
            'url5' => $news_data_raw->articles['4']->url,

            'name6' => $news_data_raw->articles['5']->source->name,
            'title6' => $news_data_raw->articles['5']->title,
            'image6' => $news_data_raw->articles['5']->urlToImage,
            'url6' => $news_data_raw->articles['5']->url,

            'name7' => $news_data_raw->articles['6']->source->name,
            'title7' => $news_data_raw->articles['6']->title,
            'image7' => $news_data_raw->articles['6']->urlToImage,
            'url7' => $news_data_raw->articles['6']->url,

            'name8' => $news_data_raw->articles['7']->source->name,
            'title8' => $news_data_raw->articles['7']->title,
            'image8' => $news_data_raw->articles['7']->urlToImage,
            'url8' => $news_data_raw->articles['7']->url
        ];

        // Chaining variable returns with ->with method 
        return view('baseview')
        ->with('weather_data', $weather_data)
        ->with('lon', $lon)
        ->with('lat', $lat)
        ->with('location', $location)
        ->with('news_data', $news_data);
    
    }
}
