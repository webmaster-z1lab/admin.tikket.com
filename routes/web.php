<?php

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

Route::get('login', function () {
    $client = new \GuzzleHttp\Client();

    $respone = $client->post(str_finish(env('AUTH_SERVER'), '/api/actions/login'), [
        'json' => [
            'email' => 'filipe-pinheiro@hotmail.com',
            'password' => '12345678'
        ]
    ]);

    $data = json_decode($respone->getBody());

    return redirect(OpenID::askForToken() . '&token=' . $data->access_token);
})->name('login');

Route::view('/', 'home.index')->name('home')->middleware('auth');

Route::prefix('evento')->as('event.')->group(function ()
{
    Route::view('/novo-evento/{event?}', 'event.new')->name('new');
});
