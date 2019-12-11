<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();


// ***************** Admin ********************************
Route::get('/admin', function(){
    if(auth()->check()){
        return redirect()->route('admin.home');
    }else{
        return view('admin.login');
    }
})->name('admin_login');

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => ['auth', 'admin']],function ($router){
    Route::get('home', 'HomeController@index')->name('admin.home');
    Route::post('profile', 'HomeController@change_profile')->name('admin.profile');
    Route::get('password', 'HomeController@change_password')->name('admin.password');
    Route::get('setting', 'HomeController@setting')->name('admin.setting');
    
    Route::post('add_place', 'HomeController@add_place')->name('admin.add_place');
    Route::post('delete_place', 'HomeController@delete_place')->name('admin.delete_place');
    Route::post('add_food', 'HomeController@add_food')->name('admin.add_food');
    Route::post('delete_food', 'HomeController@delete_food')->name('admin.delete_food');

    Route::any('user_manage', 'UserManageController@index')->name('admin.user_manage');
    Route::any('user_manage_host', 'UserManageController@user_manage_host')->name('admin.user_manage_host');
    Route::any('user_manage_guest', 'UserManageController@user_manage_guest')->name('admin.user_manage_guest');

    Route::get('user_detail/{id?}', 'UserManageController@user_detail')->name('admin.user_detail');
    Route::post('user_status_change', 'UserManageController@user_status_change')->name('admin.user_status_change');
    Route::get('host_status_change/{id}', 'UserManageController@host_status_change')->name('admin.host_status_change');

    Route::any('wajba_manage', 'WajbaManageController@index')->name('admin.wajba_manage');
    Route::any('wajba_manage_approve', 'WajbaManageController@wajba_manage_approve')->name('admin.wajba_manage_approve');
    Route::any('wajba_manage_pending', 'WajbaManageController@wajba_manage_pending')->name('admin.wajba_manage_pending');
    Route::any('wajba_manage_reject', 'WajbaManageController@wajba_manage_reject')->name('admin.wajba_manage_reject');
    Route::get('wajba_detail/{id?}', 'WajbaManageController@wajba_detail')->name('admin.wajba_detail');
    Route::post('wajba_status_change', 'WajbaManageController@wajba_status_change')->name('admin.wajba_status_change');

    Route::any('booking_manage_approve', 'BookingManageController@index')->name('admin.booking_manage_approve');
    Route::any('booking_manage_pending', 'BookingManageController@booking_manage_pending')->name('admin.booking_manage_pending');
    Route::any('booking_manage_rejected', 'BookingManageController@booking_manage_rejected')->name('admin.booking_manage_rejected');
    Route::get('booking_detail/{id?}', 'BookingManageController@booking_detail')->name('admin.booking_detail');

    Route::any('history', 'HistoryController@index')->name('admin.history');

    Route::get('mark_read', 'WajbaManageController@mark_read')->name('admin.mark_read');
});


// ***************** Frontend *****************************
// Route::get('/', 'WelcomeController@come')->name('come');
Route::get('/', 'WelcomeController@index')->name('welcome');
Route::get('about_us', 'WelcomeController@about_us')->name('about_us');
Route::get('contact_us', 'WelcomeController@contact_us')->name('contact_us');
Route::get('terms', 'WelcomeController@terms')->name('terms');
Route::get('privacy', 'WelcomeController@privacy')->name('privacy');
Route::get('faq', 'WelcomeController@faq')->name('faq');
Route::get('phone_confirm_login', 'WelcomeController@phone_confirm_login');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/get_notify', 'HomeController@get_notify')->name('get_notify');
Route::get('/become_host', 'HomeController@become_host')->name('become_host');
Route::get('/check_id', 'HomeController@check_id')->name('check_id');
Route::post('/become_host', 'HomeController@become_host_save')->name('become_host_save');
Route::post('/profile_edit', 'HomeController@profile_edit')->name('profile_edit');

Route::get('/booking_edit/{id}', 'BookingController@booking_edit')->name('booking_edit');
Route::get('/get_host_booking', 'BookingController@get_host_booking')->name('get_host_booking');
Route::get('/get_guest_booking', 'BookingController@get_guest_booking')->name('get_guest_booking');
Route::post('/booking_status_change', 'BookingController@booking_status_change')->name('booking_status_change');
// Route::get('check_auth', 'WelcomeController@check_auth')->name('check_auth');
Route::get('creat_booking', 'BookingController@index')->name('creat_booking');
Route::get('booking_detail/{id}', 'BookingController@booking_detail')->name('booking_detail');


Route::get('/experience_edit/{id}', 'HomeController@experience_edit')->name('experience_edit');
Route::post('/edit_hihome', 'HomeController@edit_hihome')->name('edit_hihome');
Route::get('/get_experience', 'HomeController@get_experience')->name('get_experience');
Route::get('/new_experience', 'HomeController@new_experience')->name('new_experience');
Route::post('/create_hihome', 'HomeController@create_hihome')->name('create_hihome');
Route::get('gallery_delete', 'HomeController@gallery_delete')->name('gallery_delete');
Route::get('change_password', 'HomeController@change_password')->name('change_password');

Route::get('/wajba_detail/{id}', 'WelcomeController@wajba_detail')->name('wajba_detail');
Route::get('/get_available', 'WelcomeController@get_available')->name('get_available');