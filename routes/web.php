<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\Dashboard\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\NewSubscriberController;
use App\Http\Controllers\Frontend\PostController;
use App\Http\Controllers\Frontend\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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

    //search controller
    Route::match(['get' , 'post'],'/search' , SearchController::class)->name('search');

    //dashboard routes
    Route::prefix('account/')->name('dashboard.')->middleware(['auth:web' , 'verified'])->group(function () {
        //profile
        Route::controller(ProfileController::class)->group(function () {
            Route::get('profile' , 'index')->name('profile');
            Route::post('post/store' , 'storePost')->name('post.store');
            Route::get('post/edit/{slug}' , 'editPost')->name('post.edit');
            Route::delete('post/delete' , 'deletePost')->name('post.delete');
            Route::get('post/get-comments/{postId}' , 'getComments')->name('post.getComments');
        });
    });

});

//overwrites the routes in vendor/laravel/ui/src/authroutes , **doesnt work there because of package problem
Route::prefix('email')->name('verification.')->controller(VerificationController::class)->group(function () {
    Route::get('/verify',  'show')->name('notice');
    Route::get('/verify/{id}/{hash}','verify')->name('verify');
    Route::post('/resend', 'resend')->name('resend');
});

//auth routes by laravel ui package
Auth::routes();



