<?php

use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::get('/device/threshold', 'DeviceController@threshold')->name('device.threshold');
Route::put('/device/threshold', 'DeviceController@threshold')->name('device.threshold');
Route::resource('device', 'DeviceController', ['except' => ['show']]);
Route::get('/device/{device}/{time}', 'DeviceController@show')->name('device.show');

Route::resource('user', 'UserController');
Route::resource('acl', 'AclController');

Route::get('/', 'HomeController@index');