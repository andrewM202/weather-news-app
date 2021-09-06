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

        function populate_news($weather_data_raw) {
            $news_api_key = env('NEWS1_API_KEY');
            $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.$weather_data_raw['sys']['country'].'&apiKey='.$news_api_key;
            $news_data_raw = json_decode(file_get_contents($news_api_url));

            // if the country the weather api gives is bad, default to US
            try {
                $news_data_raw = json_decode(file_get_contents($news_api_url));
                $test = $news_data_raw->articles['0']->source->name;
            } catch (\Throwable $e) {
                $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.'us'.'&apiKey='.$news_api_key;
                $news_data_raw = json_decode(@file_get_contents($news_api_url));
            } 
            
            return $news_data = [
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
        }

        $news_data = populate_news($weather_data_raw);

        // rescountries.eu API call
        $country = $weather_data_raw['sys']['country'];
        $country_api_url = json_decode(file_get_contents('https://restcountries.eu/rest/v2/alpha/'.$country), true);
        $country_data = [
            'country_capital' => 'Capital City: '.$country_api_url['capital'],
            'country_language' => 'Language: '.$country_api_url['languages']['0']['name'],
            'country_currency' => 'Currency: '.$country_api_url['currencies']['0']['code'],
            'country_population' => 'Population: '.$country_api_url['population'],
            'country_region' => 'Region: '.$country_api_url['region'],
            'country_regional_block' => 'Regional Block: '.$country_api_url['regionalBlocs']['0']['acronym']
        ];
        $country_name = 'Country: '.$country_api_url['name'];
        $country_flag = $country_api_url['flag'];

        // Chaining variable returns with ->with method 
        return view('baseview')
        ->with('weather_data', $weather_data)
        ->with('lon', $lon)
        ->with('lat', $lat)
        ->with('location', $location)
        ->with('country_data', $country_data)
        ->with('country_name', $country_name)
        ->with('country_flag', $country_flag)
        ->with('news_data', $news_data);

    }

    // used with HTML form to search for weather
    public function weather_search(Request $request) {
        $request = $request->city;
        return redirect()->route('get_weather', $request);
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
        $news_api_key = env('NEWS1_API_KEY');
        $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.$weather_data_raw['sys']['country'].'&apiKey='.$news_api_key;
        $news_data_raw = json_decode(file_get_contents($news_api_url));

         // if the country the weather api gives is bad, default to US
         try {
            $news_data_raw = json_decode(file_get_contents($news_api_url));
            $test = $news_data_raw->articles['0']->source->name;
        } catch (\Throwable $e) {
            $news_api_url = 'https://newsapi.org/v2/top-headlines?country='.'us'.'&apiKey='.$news_api_key;
            $news_data_raw = json_decode(@file_get_contents($news_api_url));
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

        // rescountries.eu API call
        $country = $weather_data_raw['sys']['country'];
        $country_api_url = json_decode(file_get_contents('https://restcountries.eu/rest/v2/alpha/'.$country), true);
        $country_data = [
            'country_capital' => 'Capital City: '.$country_api_url['capital'],
            'country_language' => 'Language: '.$country_api_url['languages']['0']['name'],
            'country_currency' => 'Currency: '.$country_api_url['currencies']['0']['code'],
            'country_population' => 'Population: '.$country_api_url['population'],
            'country_region' => 'Region: '.$country_api_url['region'],
            'country_regional_block' => 'Regional Block: '.$country_api_url['regionalBlocs']['0']['acronym']
        ];
        $country_name = 'Country: '.$country_api_url['name'];
        $country_flag = $country_api_url['flag'];

        // Chaining variable returns with ->with method 
        return view('baseview')
        ->with('weather_data', $weather_data)
        ->with('lon', $lon)
        ->with('lat', $lat)
        ->with('location', $location)
        ->with('country_data', $country_data)
        ->with('country_name', $country_name)
        ->with('country_flag', $country_flag)
        ->with('news_data', $news_data);
    
    }

    public function printroutetest() {
        // Print out the url
        print_r(route('test'));
        echo "<br>";
        // doesnt work but basically do same thing but in html
        print_r("<a href='{{ route('test') }} '>Test</a>");
    }
}
