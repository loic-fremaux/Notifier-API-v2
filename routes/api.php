<?php

use App\Http\Controllers\ApiNotificationController;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\ApiAuthMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(["api"])->group(function () {
    Route::post('push', function (Request $request) {
        return (new ApiNotificationController())->push($request);
    })->name('api.push');

    Route::post("register-device", function (Request $request) {
        return (new FirebaseController())->registerDevice($request);
    })->name("api.register");

});

