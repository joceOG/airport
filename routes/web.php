<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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

Route::get('/', function () {
    return view('welcome');
});


Route::post('/x', function (Request $request) {
    $client = new GuzzleHttp\Client();
    $form_params = [];
    foreach($request->all() as $key => $value) {
        if( $key == 'url' || $key == 'method'){
            continue;
        }
        $form_params[$key] = $value;
    }
    $response = $client->request($request->input('method'), $request->input('url'), [
        'headers'=> [
            'Accept'     => '*/*',
            'Content-Type' => 'application/json',
        ],
        'form_params' => $form_params
    ]);
    $contents = $response->getBody()->getContents();
    $result = json_decode($contents);

    return($result);
});