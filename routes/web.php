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

$router->group(['prefix' => '/api'], function() use ($router) {
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
});
