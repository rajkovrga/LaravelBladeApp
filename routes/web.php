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
Route::get('/result','FrontController@result');

Route::get('/blog/{id}','FrontController@post');
Route::get('/comments/{id}/page/{page}','PostController@moreComments');
Route::post('/create/comment/{id}','PostController@createComment');
Route::post('/post/like','PostController@like');
Route::post('/post/unlike','PostController@unlike');
Route::post('/comment/like','PostController@likeComment');
Route::post('/comment/unlike','PostController@unlikeComment');
Route::post('/post/update/{id}','PostController@edit');
Route::post('/delete/{id}','PostController@delete');
Route::get('/profile','FrontController@profile');
Route::get('/404','FrontController@notfound');
Route::get('/500','FrontController@notfound');
