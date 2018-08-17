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

Route::middleware('auth')->group(function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::prefix('user')->namespace('User')->name('user.')->group(function () {
        // User
        Route::get('/', 'UserController@index')->name('index');
        Route::post('/', 'UserController@update')->name('update');
        Route::get('/edit', 'UserController@edit')->name('edit');
        Route::get('/password', 'UserController@passwordEdit')->name('password.edit');
        Route::post('/password', 'UserController@passwordUpdate')->name('password.update');
        Route::get('/delete', 'UserController@delete')->name('delete');
        Route::post('/delete', 'UserController@destroy')->name('destroy');
        Route::get('/payment', 'CheckoutController@payment')->name('payment');
        Route::post('/payment', 'CheckoutController@charge')->name('payment.charge');
        Route::get('/history', 'UserController@history')->name('history');

        // Subscription
        Route::prefix('/subscription')->name('subscription.')->group(function () {
            Route::get('/', 'SubscriptionController@create')->name('index');
            Route::post('/', 'SubscriptionController@store')->name('store');
        });

        // Gift
        Route::prefix('/gift')->name('gift.')->group(function () {
            Route::get('/', 'GiftController@create')->name('index');
            Route::post('/', 'GiftController@store')->name('store');
        });

        // Post
        Route::prefix('/post')->name('post.')->group(function () {
            Route::get('/', 'PostController@index')->name('index');
            Route::post('/', 'PostController@store')->name('store');
            Route::post('/{post}/update', 'PostController@update')->name('update');
            Route::get('/create', 'PostController@create')->name('create');
            Route::get('/show', 'PostController@show')->name('show');
            Route::get('/edit', 'PostController@edit')->name('edit');
            Route::get('/delete', 'PostController@softDelete')->name('beforedelete');
        });
    });

    Route::prefix('admin')->middleware('role')->namespace('Admin')->name('admin.')->group(function () {
        // Search
        Route::get('/search', 'SearchController@search')->name('search');

        // User
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', 'UserController@index')->name('index');
            Route::post('/', 'UserController@store')->name('store');
            Route::get('/create', 'UserController@create')->name('create');
            Route::get('/{user}', 'UserController@show')->name('show');
            Route::get('/{user}/delete', 'UserController@softDelete')->name('softdelete');
            Route::get('/{user}/before', 'UserController@beforeDelete')->name('beforedelete');
        });

        // Subscription
        Route::prefix('subscription')->name('subscription.')->group(function () {
            Route::get('/', 'SubscriptionController@index')->name('index');
            Route::post('/', 'SubscriptionController@store')->name('store');
            Route::get('/create', 'SubscriptionController@create')->name('create');
            Route::get('/{subscription}', 'SubscriptionController@edit')->name('edit');
            Route::post('/{subscription}', 'SubscriptionController@update')->name('update');
            Route::get('/{subscription}/beforedelete', 'SubscriptionController@beforeDelete')->name('beforedelete');
            Route::get('/{subscription}/destroy/', 'SubscriptionController@destroy')->name('destroy');
        });

        // Gift
        Route::prefix('gift')->name('gift.')->group(function () {
            Route::get('/', 'GiftController@index')->name('index');
            Route::post('/', 'GiftController@create')->name('create');
            Route::get('/create', 'GiftController@show')->name('show');
            Route::get('/{gift}', 'GiftController@edit')->name('edit');
            Route::post('/{gift}', 'GiftController@update')->name('update');
            Route::get('/{gift}/delete', 'GiftController@delete')->name('delete');
            Route::delete('/{gift}/delete', 'GiftController@destroy')->name('destroy');
        });

        // Newsletter
        Route::prefix('newsletter')->name('newsletter.')->group(function () {
            Route::get('/', 'NewsletterController@index')->name('index');
            Route::post('/', 'NewsletterController@store')->name('store');
            Route::get('/create', 'NewsletterController@create')->name('create');
            Route::get('/{newsletter}', 'NewsletterController@edit')->name('edit');
            Route::post('/{newsletter}', 'NewsletterController@update')->name('update');
            Route::get('/{newsletter}/duplicate', 'NewsletterController@duplicate')->name('duplicate');
            Route::get('/{newsletter}/before-delete', 'NewsletterController@beforeDelete')->name('beforedelete');
            Route::get('/{newsletter}/delete', 'NewsletterController@delete')->name('delete');
        });

        // Mailing
        Route::prefix('mailing')->name('mailing.')->group(function () {
            Route::get('/', 'MailingController@index')->name('index');
            Route::get('/{mailing}', 'MailingController@edit')->name('edit');
            Route::post('/{mailing}', 'MailingController@update')->name('update');
        });

        // Session
        Route::prefix('session')->name('session.')->group(function () {
            Route::get('/', 'SessionController@index')->name('index');
            Route::delete('/{session}', 'SessionController@destroy')->name('delete');
        });
    });
});

// Output
Route::get('/optout/{subscription}/{user}', 'User\SubscriptionController@optout')->name('optout');

// Auth
Auth::routes();
