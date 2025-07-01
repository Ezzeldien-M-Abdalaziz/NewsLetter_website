<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
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

//redirects / to /home
Route::redirect('/' , '/home');


Route::group(['as' => 'frontend.',], function () {
    Route::get('/home', [HomeController::class , 'index'])->name('index');
    Route::post('news-subscribe', [NewSubscriberController::class, 'store'])->name('news.subscribe');
    Route::get('/category/{slug}' , CategoryController::class)->name('category.posts');

    //post controller
    Route::controller(PostController::class)->name('post.')->prefix('post')->group(function () {
        Route::get('/{slug}' ,  'show')->name('show');
        Route::get('/comments/{slug}' ,  'getAlls')->name('getAllComments');
        Route::post('/comments/store' ,  'saveComment')->name('comments.store');
    });


    //contact controller
    Route::controller(ContactController::class)->name('contact.')->prefix('contact-us')->group(function () {
        Route::get('/' ,  'index')->name('index');
        Route::post('/store' ,  'store')->name('store');
    });

    //seaech controller
    Route::match(['get' , 'post'],'/search' , SearchController::class)->name('search');


});
//overwrites the routes in vendor/laravel/ui/src/authroutes , **doesnt work there because of package problem
Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get('/verify', action: 'show')->name('notice');
    Route::get('/verify/{id}/{hash}','verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');
});

Auth::routes();



