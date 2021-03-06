<?php

use App\Models\User;

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

$router->group(['prefix' => 'test'], function () use ($router) {
    $router->get('/a', function () {
        return User::all();
    });
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->post('/refresh', 'AuthController@refresh');

    $router->group(['prefix' => 'recipe'], function () use ($router) {
        $router->get('/', 'RecipeController@getAllRecipe');
        $router->get('/{id}', 'RecipeController@getRecipeById');
    });

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->post('/logout', 'AuthController@logout');
        $router->get('/me', 'AuthController@me');
        $router->get('/like', 'RecipeLikeController@getLikeRecipes');
        $router->patch('/me', 'AuthController@updateProfile');
        $router->group(['prefix' => 'recipe'], function () use ($router) {
            $router->post('/', 'RecipeController@createRecipe');
            $router->patch('/{id}', 'RecipeController@changeMyRecipe');
            $router->delete('/{id}', 'RecipeController@deleteMyRecipe');
            $router->get('/{id}/like', 'RecipeLikeController@likeRecipe');
            $router->delete('/{id}/like', 'RecipeLikeController@unlikeRecipe');
        });
    });
});
