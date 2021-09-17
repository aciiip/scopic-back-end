<?php

use Illuminate\Routing\Router;
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

Route::group(['namespace' => 'Api'], function (Router $router) {
    $router->post('/login', 'UserController@login');
    $router->group(['middleware' => ['check.token']], function (Router $router) {
        $router->get('/me', 'UserController@profile');
        $router->get('/product', 'ProductController@index');
        $router->get('/product/{id}', 'ProductController@show');
        $router->post('/bid/{productId}', 'BidController@bid');
        $router->get('/auto-bidding/{productId}', 'AutoBiddingController@getByProductId');
        $router->post('/auto-bidding/{productId}', 'AutoBiddingController@create');
        $router->delete('/auto-bidding/{productId}', 'AutoBiddingController@destroy');
        $router->get('/auto-bid-setting', 'AutoBidSettingController@index');
        $router->post('/auto-bid-setting', 'AutoBidSettingController@store');
    });
});
