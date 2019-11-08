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

Route::get('/', 'AdminController@index')->name('admin');
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
	Route::get('/', 'AdminController@index');
	Route::get('/logout', 'AdminController@logout')->middleware('auth')->name('logout');

	// Route Master Content
	Route::resource('/categories', 'CategoryController');
	Route::resource('/items', 'ItemController');
	Route::resource('/vendors', 'VendorController');
	Route::resource('/locations', 'LocationController');
	Route::resource('/spks', 'SpkController');

	// Route Transaksi Content
	Route::resource('/incomings', 'IncomingController');
	Route::resource('/outgoings', 'OutgoingController');

	//Route untuk Data Ajax Master Content
	Route::get('data_category', 'CategoryController@data_category')->name('data_category');
	Route::get('data_item', 'ItemController@data_item')->name('data_item');
	Route::get('data_vendor', 'VendorController@data_vendor')->name('data_vendor');
	Route::get('data_location', 'LocationController@data_location')->name('data_location');
	Route::get('data_spk', 'SpkController@data_spk')->name('data_spk');

	//Route untuk Data Ajax Transaksi Content
	Route::get('data_incoming', 'IncomingController@data_incoming')->name('data_incoming');
	Route::get('data_outgoing', 'OutgoingController@data_outgoing')->name('data_outgoing');

	// Route Settings
	Route::resource('/users', 'UserController');
	Route::resource('/permissions', 'PermissionController');
	Route::resource('/roles', 'RoleController');

	// Route untuk Data Ajax for request and response
	Route::get('data_user', 'UserController@data_user')->name('data_user');
	Route::get('data_role', 'RoleController@data_role')->name('data_role');
	Route::get('data_permission', 'PermissionController@data_permission')->name('data_permission');
	
});
