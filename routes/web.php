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

// onko kirjautunut?

Route::group(['middleware' => 'auth'], function () {
  Route::get('/posts/create', 'PostController@create');
  Route::post('/posts', 'PostController@store');
  Route::post('/posts/{post}/comments', 'CommentController@store');

});

// admin-näkymä & pyynnöt

Route::group(['middleware' => ['auth', 'adminOnly']], function () {
  Route::get('/users', 'AdminController@index');
  Route::get('/users/{user}', 'AdminController@show');
  Route::post('users/{user}/delete', 'AdminController@destroy');
  Route::post('users/{user}/moderate', 'AdminController@makeMod');
  Route::post('users/{user}/demoderate', 'AdminController@unmakeMod');

});

// testaus

Route::group(['middleware' => ['auth', 'checkEdit']], function () {

});

// Vähän ankea toteutus halutulle toiminnallisuudelle != roolit

Route::group(['middleware' => ['auth', 'modOnly']], function () {
  Route::post('posts/{post}/edit', 'PostController@update');
  Route::get('posts/{post}/edit', 'PostController@edit');
  Route::post('posts/{post}/delete', 'PostController@destroy');


});

// guest

Route::get('/', 'PostController@index')->name('home');
Route::get('/posts/{post}', 'PostController@show');
Route::get('/posts/tags/{tag}', 'TagController@index');

Route::get('/register', 'RegistrationController@create');
Route::post('/register', 'RegistrationController@store');

Route::get('/login', ['as' => 'login', 'uses' => 'SessionController@create']);
Route::post('/login', 'SessionController@store');
Route::get('/logout', 'SessionController@destroy');
