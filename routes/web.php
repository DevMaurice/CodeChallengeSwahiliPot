<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('ussd','UssdController@handle');
