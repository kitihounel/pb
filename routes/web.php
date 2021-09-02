<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

$router->group(['prefix' => '/api'], function() use ($router) {
    $router->post('/login', 'Api\LoginController@login');

    $router->get('/doctors',                'Api\DoctorController@index');
    $router->get('/doctors/{doctor}',       'Api\DoctorController@show');
    $router->post('/doctors',               'Api\DoctorController@store');
    $router->put('/doctors/{doctor}',       'Api\DoctorController@update');
    $router->delete('/doctors/{doctor}',    'Api\DoctorController@destroy');

    $router->get('/drugs',              'Api\DrugController@index');
    $router->post('/drugs',             'Api\DrugController@store');
    $router->get('/drugs/{drug}',       'Api\DrugController@show');
    $router->put('/drugs/{drug}',       'Api\DrugController@update');
    $router->delete('/drugs/{drug}',    'Api\DrugController@destroy');

    $router->get('/customers',                  'Api\CustomerController@index');
    $router->post('/customers',                 'Api\CustomerController@store');
    $router->get('/customers/{customer}',       'Api\CustomerController@show');
    $router->put('/customers/{customer}',       'Api\CustomerController@update');
    $router->delete('/customers/{customer}',    'Api\CustomerController@destroy');

    $router->get('/sales',                      'Api\SaleController@index');
    $router->post('/sales',                     'Api\SaleController@store');
    $router->get('/sales/{sale}',               'Api\SaleController@show');
    $router->put('/sales/{sale}',               'Api\SaleController@update');
    $router->delete('/sales/{sale}',            'Api\SaleController@destroy');
    $router->post('/sales/{sale}/add-drug',     'Api\SaleController@addItem');
    $router->post('/sales/{sale}/remove-drug',  'Api\SaleController@removeItem');
    $router->get('/sales-review',               'Api\SaleController@salesReview');

    $router->get('/users',             'Api\UserController@index');
    $router->post('/users',            'Api\UserController@store');
    $router->get('/users/{user}',      'Api\UserController@show');
    $router->put('/users/{user}',      'Api\UserController@update');
    $router->delete('/users/{user}',   'Api\UserController@destroy');

    $router->get('/user', 'Api\ProfileController@index');
});

$router->options('/login', function() {
    return (new Response('', 200))->withHeaders([
        'Access-Control-Allow-Methods' => 'POST',
        'Access-Control-Max-Age' => 86400
    ]);
});

$router->options('/api/user', function() {
    return (new Response('', 200))->withHeaders([
        'Access-Control-Allow-Headers' => 'Authorization',
        'Access-Control-Allow-Methods' => 'GET',
        'Access-Control-Max-Age' => 86400,
    ]);
});

$router->options('/api/{route:.*}/', function($route) {
    error_log('wildcard route' . $route, 0);
    return (new Response('', 200))->withHeaders([
        'Access-Control-Allow-Headers' => 'Authorization',
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
        'Access-Control-Allow-Origin' => 'http://localhost:4200',
        'Access-Control-Max-Age' => 86400
    ]);
});
