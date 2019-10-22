<?php

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

$router->post('auth/login', [
        'uses' => 'AuthController@authenticate'
    ]
);

$router->post('auth/register', [
        'uses' => 'AuthController@register'
    ]
);

$router->get('products', ['uses' => 'ProductsController@index']);

$router->group(['middleware' => 'jwt.auth'], function() use ($router) {
    $router->get('dashboard', ['uses' => 'DashboardController@index']);

    $router->get('users', ['uses' => 'UsersController@index']);

    $router->get('orders', ['uses' => 'OrdersController@index']);
    $router->post('orders', ['uses' => 'OrdersController@store']);
    $router->put('orders/{id}', ['uses' => 'OrdersController@update']);

    $router->get('permissions', ['uses' => 'PermissionsController@index']);

});


$router->get('/', function () use ($router) {
    return $router->app->version();
});
