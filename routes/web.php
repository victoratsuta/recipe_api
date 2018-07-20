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

$router->group(['prefix' => 'api'], function ($router) {
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'UserController@register');

    $router->group(
        [
            'middleware' => 'jwt.auth',
            'prefix' => 'recipe'
        ],
        function () use ($router) {

            $router->get('{id}', 'RecipeController@get');

            $router->post('/', 'RecipeController@store');

            $router->put('{id}', 'RecipeController@update');

            $router->delete('{id}', 'RecipeController@delete');

            $router->post('image/{id}', 'RecipeController@imageUpdate');

        }
    );

});
