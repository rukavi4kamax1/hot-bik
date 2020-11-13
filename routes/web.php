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
 * Рути для навігації користувача по сайту
 */
Route::get('/{id}', ["as" => "page", "uses" => "App\Http\Controllers\PageController@get_page"]);

/*
 * Рути для створення контенту
*/
Route::get('/create/{pid}', ["as" => "create", "uses" => "App\Http\Controllers\PageController@create"]);
Route::post('/create/directory', ["as" => "create_dir", "uses" => "App\Http\Controllers\ContentController@create_directory"]);
Route::post('/create/product', ["as" => "create_prod", "uses" => "App\Http\Controllers\ContentController@create_product"]);
Route::post('/create/alias', ["as" => "create_alias", "uses" => "App\Http\Controllers\ContentController@create_alias"]);

/*
 *  Рути для оновлення контенту
 */
Route::get('/update/{id}', ["as" => "update", "uses" => "App\Http\Controllers\PageController@update"]);
Route::post('/update/directory', ["as" => "upd_dir", "uses" => "App\Http\Controllers\ContentController@update_directory"]);
Route::post('/update/product', ["as" => "upd_product", "uses" => "App\Http\Controllers\ContentController@update_product"]);
Route::post('/update/alias', ["as" => "upd_alias", "uses" => "App\Http\Controllers\ContentController@update_alias"]);

/*
 * Рути для видалення контенту
*/
Route::get('/remove/{id}&{pid}', ["as" => "rm_content", "uses" => "App\Http\Controllers\ContentController@rm_content"]);
