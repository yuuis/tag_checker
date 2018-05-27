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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

/**
 * Route::get('/test/{name}', 'Test\TestController@index');
 * と記載した場合{name}がパラメータとして渡される
 * Route::get('/test', 'Test\TestController@index');
 * を入れなかった場合は http://xxxx/test のアクセスが404になる
Route::match(['get', 'post'], '/test/{name}', 'Test\TestController@index');
Route::match(['get', 'post'], '/test', 'Test\TestController@index');
 */

/*
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'web', 'namespace' => 'Admin'], function () {
	Route::resource('product', 'ProductController');
});
*/
/**
 * prefix : URLの先頭につけるパス「admin」なら「http://xxxxx/admin/xxxx」となる
 * middleware : このグループに設定するMiddleware、コントローラーより先に実行される
 * namespace : デフォルトのアクセス先「Test」とした場合で、リソースのアクセス先を「TestController」とした場合、実体は「Test\TestController」となる
 * Controllerのメソッドで引数を指定すると、
Route::group(['prefix' => 'admin', 'middleware' => 'beforeWeb', 'namespace' => 'Test'], function () {
	Route::resource('test', 'TestController');
});
Route::group(['prefix' => '{path}', 'middleware' => ['beforeWeb', 'afterWeb']], function () {
	Route::resource('test', 'Test\TestController', ['parameters' => [
		'name' => 'name'
	]]);
});
 */

// Memcachedアクセステスト

// Route::resource('/', 'App\Controllers\KeywordController');
Route::get('/', function () {
    return view('tagcheck.form');
});

Route::post('/tagcheck', 'TagCheck\TagCheckController@tagcheck');


// Route::match(['get', 'post'], '/mail/form/{companySid}', 'Mail\MailController@form');
// Route::match(['get', 'post'], '/mail/sent/', 'Mail\MailController@sent');