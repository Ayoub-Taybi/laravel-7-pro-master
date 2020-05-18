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

Route::get('/', function() {
    return view('welcome');
});

Route::get('/contact', 'HomeController@contact')->name('contact');

Route::get('/posts/archive','PostController@archive')->name('posts.archive');
Route::get('/posts/all','PostController@allPost')->name('posts.all');
Route::patch('/posts/restore/{post}','PostController@restore')->name('posts.restore');
Route::delete('/posts/force/{post}','PostController@forcedelete')->name('posts.force');

Route::resource('/posts', 'PostController');


Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');
