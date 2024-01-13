<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        // Endpoint User
        $router->get('/users', 'UserController@index');
        $router->get('/users/{id}', 'UserController@show');
        $router->put('/users/{id}', 'UserController@update');
        $router->delete('/users/{id}', 'UserController@destroy');

        // Endpoint Transaksi
        $router->get('/transactions', 'TransactionController@index');
        $router->get('/transactions/{id}', 'TransactionController@show');
        $router->post('/transactions', 'TransactionController@store');
        $router->put('/transactions/{id}', 'TransactionController@update');
        $router->delete('/transactions/{id}', 'TransactionController@destroy');

        // Endpoint Kategori
        $router->get('/categories', 'CategoryController@index');
        $router->post('/categories', 'CategoryController@store');
        $router->put('/categories/{id}', 'CategoryController@update');
        $router->delete('/categories/{id}', 'CategoryController@destroy');

        // Endpoint Statistik keuangan
        $router->get('/statistics', 'StatisticController@index');
    });
});