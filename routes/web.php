<?php

use App\Http\Controllers\ApiTokenController;
use App\Http\Controllers\FirebaseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Services\ServicesController;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::middleware('auth')
    ->group(function () {

        Route::prefix('profile')->group(function () {
            Route::get('/', function (Request $request) {
                return (new ProfileController())->index($request);
            })->name('profile');

            Route::get('/reset-api-token', function (Request $request) {
                return (new ProfileController())->resetApiToken($request);
            })->name('profile.reset_api_token');
        });

        Route::prefix('firebase')->group(function () {
            Route::get('/', function (Request $request) {
                return (new FirebaseController())->index($request);
            })->name('firebase');
            Route::get('/delete/{id}', function (Request $request, $id) {
                return (new FirebaseController())->delete($request, $id);
            })->name('firebase.delete');
        });

        Route::prefix('api')->group(function () {
            Route::get('/', function (Request $request) {
                return (new ApiTokenController())->index($request);
            })->name('user.api');
            Route::get('/delete/{id}', function (Request $request, $id) {
                return (new ApiTokenController())->delete($request, $id);
            })->name('user.api.delete');
        });

        Route::prefix('services')->group(function () {
            Route::get('/', function (Request $request) {
                return (new ServicesController())->index($request);
            })->name('services');
            Route::get('inspect', function (Request $request) {
                return (new ServicesController())->index($request);
            })->name('services.inspect');
            Route::get('/new', function (Request $request) {
                return (new ServicesController())->newService($request);
            })->name('services.new');


            Route::get('/delete/{id}', function (Request $request, $id) {
                return (new ServicesController())->delete($request, $id);
            })->name('service.delete');

            Route::get('/reset/{id}', function (Request $request, $id) {
                return (new ServicesController())->resetApiKey($request, $id);
            })->name('service.reset_api_key');


            Route::post('/create', function (Request $request) {
                return (new ServicesController())->create($request);
            })->name('service.create');

            Route::post('/user/add/{id}', function (Request $request, $id) {
                return (new ServicesController())->addMember($request, $id);
            })->name('service.user.add');

            Route::get('/user/remove/{id}/{user}', function (Request $request, $id, $user) {
                return (new ServicesController())->removeMember($request, $id, $user);
            })->name('service.user.remove');
        });
    });

Auth::routes();
