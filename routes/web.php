<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\epicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Return the baseview view with a controller 
Route::get('/', [epicController::class, 'index']);

Route::get('/test',
'App\Http\Controllers\epicController@printroutetest')->name('test');

// See the weather JSON returned 
Route::get('/weather', 'App\Http\Controllers\apiTestController@weatherData');

// See the weather for specific city 
Route::get('/weather/{city}',                  // Can be 1+ letters a-z 
 'App\Http\Controllers\epicController@weather')->where('city', '[a-z]+')->name('get_weather');

// Do a weather search
Route::get('/search/',                  
 'App\Http\Controllers\epicController@weather_search')->where('city', '[a-z]+');

// See the news JSON returned 
Route::get('/news/', 'App\Http\Controllers\apiTestController@newsData');

// See pollution JSON 
Route::get('/pollution/', 'App\Http\Controllers\apiTestController@pollutionData');

Route::get('/restcountry/', 'App\Http\Controllers\apiTestController@restCountryData');

// See weather map 
Route::get('/map/', 'App\Http\Controllers\apiTestController@maps');

// Route::get('/weather/{country}/{county-number}',
// 'App\Http\Controllers\epicController@weather')->where([
//     'country' => '[a-z]+',
//     'county-number' => '[0-9]+'
// ])

// Return a json object, because by default arrays turn into JSONs 
// Route::get('/getJson', function() {
//     return response()->json([
//         'name' => 'testName', 
//         'pagetype' => 'blog'
//     ]);
// });


// Redirect a user from /getJson to homepage 
// Route::get('/getjson', function() {
//     return redirect('/');
// });

// Route::get('/studio', function() {
//     return view('bootstrap-studio');
// });

/*
Route::get('/', function() {
    return view('baseview');
});
*/

/*
Route::get('/', function() {
    // Return the environment variable DB_DATABASE from the .env file 
    //return env('DB_DATABASE');
    return env('CREATOR_NAME');
});
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/
