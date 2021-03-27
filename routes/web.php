<?php

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {
    // user routes
    $router->post('register', 'AuthController@register');
    $router->post('login', 'AuthController@login');
    $router->get('profile', 'UserController@profile');
    $router->get('users/{id}', 'UserController@singleUser');
    $router->get('users', 'UserController@allUsers');

    //transaction routes
    $router->post('add-expense','TransactionController@addExpense');
 });
