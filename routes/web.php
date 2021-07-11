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
    $router->get('/doctors', 'Api\DoctorController@index');
    $router->post('/doctors', 'Api\DoctorController@store');
    $router->get('/doctors/{id}', 'Api\DoctorController@show');
    $router->put('/doctors/{id}', 'Api\Doctorontroller@update');
    $router->delete('/doctors/{id}', 'Api\DoctorController@destroy');
});
