<?php

use Illuminate\Support\Facades\Route;

// route callback
Route::post('callback', App\Http\Controllers\Api\CallbackController::class);
