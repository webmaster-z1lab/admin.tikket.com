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

Route::get('login', '\Z1lab\OpenID\Http\Controllers\LoginController@index')->middleware('guest')->name('login');

Route::get('', 'HomeController@index')->name('home');

Route::prefix('evento')->as('event.')->middleware('auth')->group(function ()
{
    Route::get('/meus-eventos', 'EventController@myEvents')->name('my-events');
    Route::get('/novo-evento', 'EventController@create')->name('create');
    Route::get('/{id}/{vue?}', 'EventController@administration')->where('id', '\b[0-9a-fA-F]{24}\b')->where('vue', '.*')->name('edit');
    Route::get('/pedido-manual/{id}', 'EventController@orderManual')->where('id', '\b[0-9a-fA-F]{24}\b')->name('order-manual');
});
