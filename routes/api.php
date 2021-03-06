<?php

use App\Http\Controllers\ApiNotificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FirebaseController;
use App\Http\Middleware\VerifyCsrfToken;
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

    Route::post("update-device", function (Request $request) {
        return (new FirebaseController())->updateDevice($request);
    })->name("api.update");
});

Route::middleware(["web"])->group(function () {
    Route::post('login', function (Request $request) {
        return (new LoginController())->apiLogin($request);
    })->name('api.login')
        ->withoutMiddleware(VerifyCsrfToken::class);
});
