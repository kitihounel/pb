<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * This function activates support for CORS on the dev machine.
 * 
 * CORS is only used in dev mode since the frontend is in another repository.
 * The frontend is an Angular app, which runs its dev server at http://localhost:4200.
 * Since this is not the same origin as the backend, we need to support CORS.
 * We also support CORS for the local production server which is accessed by the frontend.
 *
 * @param  \Laravel\Lumen\Routing\Router $router
 */
function addCorsSupportInDevMode($router)
{
    $ip = $_SERVER['REMOTE_ADDR'];
    if ($ip != '127.0.0.1')
        return;

    $router->options('/api/login', function () {
        return response('', 200)->withHeaders([
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Access-Control-Allow-Methods' => 'POST',
            'Access-Control-Max-Age' => 86400
        ]);
    });

    $router->options('/api/user', function () {
        return response('', 200)->withHeaders([
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type',
            'Access-Control-Allow-Methods' => 'GET',
            'Access-Control-Max-Age' => 86400,
        ]);
    });

    $router->options('/api/{route:.*}/', function () {
        return response('', 200)->withHeaders([
            'Access-Control-Allow-Headers' => 'Authorization, Content-Type',
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE',
            'Access-Control-Allow-Origin' => 'http://localhost:4200',
            'Access-Control-Max-Age' => 86400
        ]);
    });
}

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

$router->get('/', function () use (&$router) {
    return $router->app->version();
});

$router->group(['prefix' => '/api'], function () use (&$router) {
    /*
    |----------------------------------------------------------------------
    | Login route
    |----------------------------------------------------------------------
    */
    $router->post('/login', [
        'as' => 'login', 'uses' => 'Api\LoginController@login'
    ]);

    /*
    |----------------------------------------------------------------------
    | Doctor routes
    |----------------------------------------------------------------------
    */
    $router->get('/doctors', [
        'as' => 'doctors.index', 'uses' => 'Api\DoctorController@index'
    ]);
    $router->get('/doctors/{doctor}', [
        'as' => 'doctors.show', 'uses' => 'Api\DoctorController@show'
    ]);
    $router->post('/doctors', [
        'as' => 'doctors.store', 'uses' => 'Api\DoctorController@store'
    ]);
    $router->put('/doctors/{doctor}', [
        'as' => 'doctors.update', 'uses' => 'Api\DoctorController@update'
    ]);
    $router->delete('/doctors/{doctor}', [
        'as' => 'doctors.delete', 'uses' => 'Api\DoctorController@destroy'
    ]);

    /*
    |----------------------------------------------------------------------
    | Drug routes
    |----------------------------------------------------------------------
    */
    $router->get('/drugs', [
        'as' => 'drugs.index', 'uses' => 'Api\DrugController@index'
    ]);
    $router->post('/drugs', [
        'as' => 'drugs.store', 'uses' => 'Api\DrugController@store'
    ]);
    $router->get('/drugs/{drug}', [
        'as' => 'drugs.show', 'uses' => 'Api\DrugController@show'
    ]);
    $router->put('/drugs/{drug}', [
        'as' => 'drugs.update', 'uses' => 'Api\DrugController@update'
    ]);
    $router->delete('/drugs/{drug}', [
        'as' => 'drugs.delete', 'uses' => 'Api\DrugController@destroy'
    ]);

    /*
    |----------------------------------------------------------------------
    | Customer routes
    |----------------------------------------------------------------------
    */
    $router->get('/customers', [
        'as' => 'customers.index', 'uses' => 'Api\CustomerController@index'
    ]);
    $router->post('/customers', [
        'as' => 'customers.store', 'uses' => 'Api\CustomerController@store'
    ]);
    $router->get('/customers/{customer}', [
        'as' => 'customers.show', 'uses' => 'Api\CustomerController@show'
    ]);
    $router->put('/customers/{customer}', [
        'as' => 'customers.update', 'uses' => 'Api\CustomerController@update'
    ]);
    $router->delete('/customers/{customer}', [
        'as' => 'customers.delete', 'uses' => 'Api\CustomerController@destroy'
    ]);

    /*
    |----------------------------------------------------------------------
    | Sale routes
    |----------------------------------------------------------------------
    */
    $router->get('/sales', [
        'as' => 'sales.index', 'uses' => 'Api\SaleController@index'
    ]);
    $router->post('/sales', [
        'as' => 'sales.store', 'uses' => 'Api\SaleController@store'
    ]);
    $router->get('/sales/{sale}', [
        'as' => 'sales.show', 'uses' => 'Api\SaleController@show'
    ]);
    $router->put('/sales/{sale}', [
        'as' => 'sales.update', 'uses' => 'Api\SaleController@update'
    ]);
    $router->delete('/sales/{sale}', [
        'as' => 'sales.delete', 'uses' => 'Api\SaleController@destroy'
    ]);
    $router->post('/sales/{sale}/add-drug', [
        'as' => 'sales.add-drug', 'uses' => 'Api\SaleController@addItem'
    ]);
    $router->post('/sales/{sale}/remove-drug', [
        'as' => 'sales.remove-drug', 'uses' => 'Api\SaleController@removeItem'
    ]);
    $router->get('/sales-review', [
        'as' => 'sales.review', 'uses' => 'Api\SaleController@salesReview'
    ]);

    /*
    |----------------------------------------------------------------------
    | User routes
    |----------------------------------------------------------------------
    */
    $router->get('/users', [
        'as' => 'users.index', 'uses' => 'Api\UserController@index'
    ]);
    $router->post('/users', [
        'as' => 'users.store', 'uses' => 'Api\UserController@store'
    ]);
    $router->get('/users/{user}', [
        'as' => 'users.show', 'uses' => 'Api\UserController@show'
    ]);
    $router->put('/users/{user}', [
        'as' => 'users.update', 'uses' => 'Api\UserController@update'
    ]);
    $router->delete('/users/{user}', [
        'as' => 'users.delete', 'uses' => 'Api\UserController@destroy'
    ]);

    /*
    |----------------------------------------------------------------------
    | Profile
    |----------------------------------------------------------------------
    */
    $router->get('/user', [
        'as' => 'profile', 'uses' => 'Api\ProfileController@index'
    ]);
});

addCorsSupportInDevMode($router);
