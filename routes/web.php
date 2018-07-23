<?php

Route::get('/', function () {
    return view('welcome');
});

Route::get('ussd', 'UssdController@index');

Route::post('ussd', 'UssdController@handle');

Route::get('mpesa', 'MpesaController@index');
Route::post('mpesa', 'MpesaController@handle');
