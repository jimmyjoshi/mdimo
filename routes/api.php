<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function () {
    Route::post('login', 'UsersController@login')->name('api.login');
    Route::post('login-with-phone', 'UsersController@loginWithPhone')->name('api.login-with-phone');
    /*Route::post('register', 'UsersController@register')->name('api.register');
    Route::post('verifyotp', 'UsersController@verifyOtp')->name('api.verifyotp');
    Route::post('resendotp', 'UsersController@resendOtp')->name('api.resendotp');
    Route::post('forgotpassword', 'UsersController@forgotPassword')->name('api.forgotPassword');
    Route::post('specializations', 'SpecializationController@specializationList')->name('api.specializationList');
    Route::post('removeotp', 'UsersController@removeOtp')->name('api.removeotp');*/
});

Route::group(['namespace' => 'Api', 'middleware' => 'jwt.customauth'], function () {
	Route::post('update-profile', 'UsersController@updateProfile')->name('api.update-profile');
    Route::post('me', 'UsersController@me')->name('api.me');
    Route::post('update-user-profile', 'UsersController@updateUserProfile')->name('api.update-user-profile');

	Route::post('update-location', 'UsersController@updateLocation')->name('api.update-location');
});
Route::group(['middleware' => 'jwt.customauth'], function () {
    includeRouteFiles(__DIR__.'/API/');
});
