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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ----------- User Register ----------------
Route::post('phone_verify', 'API\UserManageController@phone_verify');
Route::post('phone_confirm', 'API\UserManageController@phone_confirm');
Route::post('register', 'API\UserManageController@register');

Route::post('get_wajbas', 'API\WajbaManageController@get_wajbas');
Route::post('get_date_time', 'API\WajbaManageController@get_date_time');
Route::get('get_top_city', 'API\WajbaManageController@get_top_city');
Route::get('get_top_place', 'API\WajbaManageController@get_top_place');
Route::get('get_top_food', 'API\WajbaManageController@get_top_food');

// ----------- User Login -------------------
Route::post('login', 'API\UserManageController@login');
Route::post('phone_verify_login', 'API\UserManageController@phone_verify_login');
Route::post('phone_confirm_login', 'API\UserManageController@phone_confirm_login');
Route::post('user/detail', 'API\UserManageController@user_details');

Route::group(['prefix' => 'user', 'namespace' => 'API', 'middleware' => 'auth:api'], function(){
    Route::post('host_become', 'UserManageController@host_become');
    Route::get('logout', 'UserManageController@logout');
    Route::post('change_password', 'UserManageController@change_password');
    Route::post('change_user_info', 'UserManageController@change_user_info');
    Route::post('rate_wajba', 'WajbaManageController@rate_wajba');
    Route::get('get_wajba_for_rate', 'UserManageController@get_wajba_for_rate');
    
    Route::post('add_booking', 'BookingManageController@add_booking');
    Route::post('edit_booking', 'BookingManageController@edit_booking');
    Route::post('delete_booking', 'BookingManageController@delete_booking');
    Route::get('get_my_bookings', 'BookingManageController@get_my_bookings');
    Route::post('add_payment', 'BookingManageController@add_payment');
    Route::post('change_payment_status', 'BookingManageController@change_payment_status');

    Route::post('get_wajba_history', 'HistoryController@get_wajba_history');
    Route::post('get_booking_history', 'HistoryController@get_booking_history');
    Route::post('delete_history', 'HistoryController@delete_history');

    Route::get('get_my_notifications', 'NotificationController@get_my_notifications');
    Route::post('delete_notifications', 'NotificationController@delete_notifications');
    Route::post('get_notify_by_id', 'NotificationController@get_notify_by_id');

});

// ---------- Host Action ----------------------
Route::group(['prefix' => 'host', 'namespace' => 'API', 'middleware' => ['auth:api', 'host']], function($router){
    Route::post('add_wajba', 'WajbaManageController@add_wajba');
    Route::post('edit_wajba', 'WajbaManageController@edit_wajba');
    Route::post('delete_wajba', 'WajbaManageController@delete_wajba');
    Route::get('get_my_wajbas', 'WajbaManageController@get_my_wajbas');
    Route::post('add_date', 'WajbaManageController@add_date');
    Route::post('edit_date', 'WajbaManageController@edit_date');
    Route::post('delete_date', 'WajbaManageController@delete_date');
    Route::post('add_time', 'WajbaManageController@add_time');
    Route::post('edit_time', 'WajbaManageController@edit_time');
    Route::post('delete_time', 'WajbaManageController@delete_time');

    Route::post('change_booking_status', 'BookingManageController@change_booking_status');

});


// ***************** Admin ****************************
// ---------- Admin Action ---------------------
Route::group(['prefix' => 'admin', 'namespace' => 'API', 'middleware' => ['auth:api', 'admin']], function($router){
    Route::post('approve_host', 'UserManageController@host_approve');
    Route::post('get_users', 'UserManageController@user_all');
    Route::get('get_users/non', 'UserManageController@users_non');
    Route::post('user_status_change', 'UserManageController@user_status_change');
    Route::post('host_status_change', 'UserManageController@host_status_change');

    Route::post('wajba_status_change', 'WajbaManageController@wajba_status_change');
    Route::get('get_wajba_pending', 'WajbaManageController@get_wajba_pending');
    Route::post('get_wajba_bookings', 'WajbaManageController@get_wajba_bookings');
    
    Route::post('get_wajba_by_id', 'WajbaManageController@get_wajba_by_id');
    Route::post('get_booking_by_id', 'BookingManageController@get_booking_by_id');
});
