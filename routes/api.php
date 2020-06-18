<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function(){
    // Get List Of Orders
    Route::get('/orders', ['uses'=>'Api\Order\OrderController@index','as'=>'/orders']);
    Route::post('/PlaceOrder', ['uses'=>'Api\Order\OrderController@PlaceOrder','as'=>'/PlaceOrder']);
    Route::post('/CancelOrder', ['uses'=>'Api\Order\OrderController@CancelOrder','as'=>'/CancelOrder']);
});
Route::post('/login', ['uses'=>'Api\Auth\LoginController@index','as'=>'/login']);
Route::post('/register', ['uses'=>'Api\Auth\LoginController@register','as'=>'/register']);
