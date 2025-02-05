<?php

use Illuminate\Support\Facades\Route;
use L5Swagger\Http\Controllers\SwaggerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/swagger', function () {
    return view('l5-swagger::index');
});
