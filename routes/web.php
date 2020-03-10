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
Route::get('/','FrontController@home');
Route::get('/home','FrontController@home');

Route::get('/login','FrontController@login');
Route::post('/login','AuthController@login');

Route::get('/blog','FrontController@blog');

Route::get('/logout','AuthController@logout');

Route::post('/contact','AuthController@contact');
Route::get('/contact','FrontController@contact');

Route::get('/verify','FrontController@verifyAccount');
Route::post('/register','AuthController@registration');

Route::get('/verify/email','AuthController@verify')->name('verify.email');
Route::post('/verify/again','AuthController@againVerify');
Route::get('/verified','FrontController@verified');

Route::get('/blog/{id}','FrontController@post');
Route::get('/comments/{id}/page/{page}','PostController@moreComments');
Route::post('/create/comment/{id}','PostController@createComment');
Route::post('/post/like','PostController@like');
Route::post('/post/unlike','PostController@unlike');
