<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/qqq', function (){
    return View::make('ramm', array('routeTextHere' =>'<b>текст из роута</b>'));
});
Route::resource('rest', 'RestController');
Route::group(['prefix' => 'admin'], function (){
    Route::any('/', 'AdminController@index');
});
Route::group(['prefix' => 'cron'], function (){
    Route::get('/parseaddress', 'CronController@parseaddress');//Можно включать периодически
    Route::get('/addpost/{count?}', 'CronController@addpost');//Надо включать каждую минуту
    Route::get('/addvote', 'CronController@addvote');//Надо включать каждый час по 40
    Route::get('/addaccepts', 'CronController@addaccepts');//Надо включать каждые 10 мин
});
Route::get('/', 'DefaultController@index');
Route::get('/cities/{word?}/{city?}', 'CitiesController@index');
Route::get('/poputchik/{city1?}/{city2?}', 'PostsController@index');
Route::any('/poputchik/{city1}/{city2}/{id}', 'PostsController@details');
//Route::any('/archive/', 'PostsController@archive');
Route::any('/registration/', 'UsersController@registration');
Route::any('/verification/{code}', 'UsersController@verification');
Route::any('/login/', 'UsersController@login');
Route::get('/logout/', 'UsersController@logout');
Route::get('/sitemap/', 'SitemapController@index');
Route::any('/contacts/', 'ContactsController@index');
/*
Route::get('/poputchik/{cityFrom}', 'PostsController@details1');
Route::get('/poputchik/{cityFrom}/{cityTo}', 'PostsController@details2');
Route::get('/poputchik/{cityFrom}/{cityTo}/{id}', 'PostsController@details3');
*/
/*Route::controller('admin', 'AdminController');
Route::controller('cron', 'CronController');
Route::controller('{any?}', 'DefaultController');*/
/*Route::get('/', function () {
    return view('welcome');
});*/
