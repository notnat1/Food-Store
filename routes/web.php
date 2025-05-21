<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Route;

//route register
Route::get('/register', Auth\Register::class)->name('register');

//route login
Route::get('/login', Auth\Login::class)->name('login');

//route group account
Route::middleware('auth:customer')->group(function () {
    
    Route::group(['prefix' => 'account'], function () {
        
        //route my order
        Route::get('/my-orders', Account\MyOrders\Index::class)->name('account.my-orders.index');
  
        //route my order show
        Route::get('/my-orders/{snap_token}', Account\MyOrders\Show::class)->name('account.my-orders.show');

        //route my profile
        Route::get('/my-profile', Account\MyProfile\Index::class)->name('account.my-profile');

        //route password
        Route::get('/password', Account\Password\Index::class)->name('account.password');

    });

});

//route home
Route::get('/', Web\Home\Index::class)->name('home');

//route products index
Route::get('/products', Web\Products\Index::class)->name('web.product.index');

//route category show
Route::get('/category/{slug}', Web\Category\Show::class)->name('web.category.show');

//route product show
Route::get('/products/{slug}', Web\Products\Show::class)->name('web.product.show');

//route cart
Route::get('/cart', Web\Cart\Index::class)->name('web.cart.index')->middleware('auth:customer');

//route checkout
Route::get('/checkout', Web\Checkout\Index::class)->name('web.checkout.index')->middleware('auth:customer');