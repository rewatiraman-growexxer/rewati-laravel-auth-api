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

$router->post('/register','API\AuthController@register');
$router->post('/login','API\AuthController@login');
$router->group(['prefix' => 'api/','namespace'=>'API','middleware' => 'auth'], function ($router) {
    $router->post('settings','SettingController@store');
    $router->get('settings', 'SettingController@index');
    $router->get('settings/{id}', 'SettingController@show');
    $router->put('settings/{id}', 'SettingController@update');
    $router->delete('settings/{id}', 'SettingController@destroy');
});
