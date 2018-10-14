<?php

use function Illuminate\Support\Facades\middleware;

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
    return view('tagcheck.form');
});

Route::post('/tagcheck', 'TagCheck\TagCheckController@tagcheck');