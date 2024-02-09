<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get','post'],'/register','App\Http\Controllers\AuthController@register');
Route::match(['get','post'],'/login','App\Http\Controllers\AuthController@login');

Route::match(['get','post'],'/user/logout','App\Http\Controllers\AuthController@logout');
Route::match(['get','post'],'/user/dashboard','App\Http\Controllers\AuthController@dashboard');


Route::group(['prefix' => '/admin'], function () {
  Route::match(['get','post'],'/login','App\Http\Controllers\AdminController@login');
  Route::match(['get','post'],'/logout','App\Http\Controllers\AdminController@logout');

  Route::match(['get','post'],'/events','App\Http\Controllers\EventController@index');
  Route::match(['get','post'],'/event/add','App\Http\Controllers\EventController@add');
  Route::match(['get','post'],'/event/edit/{id}','App\Http\Controllers\EventController@edit');
  Route::delete('eventdel', ['as'=>'event.destroy','uses'=>'App\Http\Controllers\EventController@destroy']);

  Route::match(['get','post'],'/event/booking/{id}','App\Http\Controllers\EventController@show_bookings');

 });

Route::group(['prefix' => '/user/task'], function () {
   Route::match(['get','post'],'/','App\Http\Controllers\TaskController@index');
   Route::match(['get','post'],'/add','App\Http\Controllers\TaskController@add');
   Route::match(['get','post'],'/edit/{id}','App\Http\Controllers\TaskController@edit');
   Route::delete('taskdel', ['as'=>'task.destroy','uses'=>'App\Http\Controllers\TaskController@destroy']);
   Route::get('/get_users/action', 'App\Http\Controllers\TaskController@get_users')->name('get_users.action');
   Route::get('/add_user_task/action', 'App\Http\Controllers\TaskController@add_user_task')->name('add_user_task.action');
});

Route::group(['prefix' => '/user/event'], function () {
    Route::match(['get','post'],'/','App\Http\Controllers\UserEventController@index');
    Route::match(['get','post'],'/booking/{id}','App\Http\Controllers\UserEventController@book_event');
});