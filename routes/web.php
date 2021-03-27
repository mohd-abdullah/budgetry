<?php

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // user routes
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');

    //categories
    $router->get('categories','CategoriesController@index');
    $router->post('categories/create','CategoriesController@create');
    $router->get('categories/{id}','CategoriesController@show');
    $router->put('categories/{id}','CategoriesController@update');
    $router->delete('categories/{id}','CategoriesController@destroy');

    //transaction
    $router->get('transactions','TransactionController@index');
    $router->post('transactions/create','TransactionController@create');
    $router->get('transactions/{id}','TransactionController@show');
    $router->put('transactions/{id}','TransactionController@update');
    $router->delete('transactions/{id}','TransactionController@destroy');
 });
