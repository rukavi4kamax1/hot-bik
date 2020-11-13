<?php

use Illuminate\Support\Facades\Route;

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
    return view('main');
});

/*
 * Рути для адмін панелі
*/
Route::get('/admin/', ["as" => "admin_root", "uses" => "App\Http\Controllers\PageController@admin_root"]);
Route::get('/admin/{id}', ["as" => "admin_page", "uses" => "App\Http\Controllers\PageController@admin_page"]);

/*
 * Рути для створення сторінок
*/
Route::get('/create/{pid}', ["as" => "create", "uses" => "App\Http\Controllers\PageController@create"]);


