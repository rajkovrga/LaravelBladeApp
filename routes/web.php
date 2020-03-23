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

Route::middleware(['no_guest','log'])->group(function ()
{
    Route::get('/logout','AuthController@logout');
    Route::get('/comments/{id}/page/{page}','PostController@moreComments');
    Route::post('/create/comment/{id}','PostController@createComment');
    Route::post('/post/like','PostController@like');
    Route::post('/post/unlike','PostController@unlike');
    Route::post('/comment/like','PostController@likeComment');
    Route::post('/comment/unlike','PostController@unlikeComment');
    Route::post('/post/update/{id}','PostController@edit');
    Route::post('/delete/{id}','PostController@delete');
    Route::get('/profile','FrontController@profile');
    Route::post('/change/email','AuthController@changeEmail');
    Route::post('/change/username','AuthController@changeUsername');
    Route::post('/user/deactive','AuthController@deactiveUser');
    Route::post('/change/password','AuthController@changePassword');
    Route::post('/change/image','AuthController@changeImage');
    Route::post('/post/create','PostController@create');
    Route::post('/download/activities','AuthController@downloadActivities');
    Route::post('/change/role','AuthController@changeRole');
});

Route::middleware(['log'])->group(function ()
{
    Route::get('/404','FrontController@notfound');
    Route::get('/500','FrontController@notfound');
    Route::get('/forbidden','FrontController@forbidden');
    Route::middleware(['signed'])->get('/verify/email','AuthController@verify')->name('verify.email');
    Route::post('/verify/again','AuthController@againVerify');
    Route::get('/result','FrontController@result');
    Route::get('/blog/{id}','FrontController@post');
    Route::get('/blog','FrontController@blog');
    Route::get('/','FrontController@home');
    Route::get('/home','FrontController@home');
    Route::get('/login','FrontController@login');
    Route::post('/login','AuthController@login');
    Route::post('/contact','AuthController@contact');
    Route::get('/contact','FrontController@contact');
    Route::post('/register','AuthController@registration');
    Route::get('/verify','FrontController@verifyAccount');
    Route::get('/forget/password','FrontController@forgetPassword');
    Route::post('/reset/password','AuthController@sendResetPasswordLink');
    Route::middleware(['signed'])->get('/reset/password','FrontController@resetPassword')->name('reset.password');
});


Route::middleware(['dashboard','log'])->prefix('dashboard')->group(function ()
{
    Route::get('/','FrontController@dashboard');
    Route::get('/insert','FrontController@insertPostDashboard');
    Route::get('/top/posts','FrontController@topPost');
    Route::get('/top/comments','FrontController@topComment');
    Route::get('/users','FrontController@dashboardUsers');
    Route::get('/activities','FrontController@userActivities');
});
