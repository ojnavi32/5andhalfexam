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

Route::resource('document', 'Document');

#Pet routes
Route::get('/pet/findByTags', 'PetsController@findByTags');
Route::get('/pet/{petId}', 'PetsController@findById');
Route::post('/pet/{petId}', 'PetsController@updateWithId');
Route::post('/pet', 'PetsController@store');
Route::post('/pet/{petId}/uploadImage', 'PetsController@uploadImage');
Route::put('/pet', 'PetsController@update');
Route::delete('/pet/{petId}', 'PetsController@destroy');

#Store routes
Route::get('/store/order/{orderId}', 'StoreController@getOrderById');
Route::post('/store/order', 'StoreController@storeOrder');
Route::delete('/store/order/{orderId}', 'StoreController@destroy');