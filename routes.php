<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
$router->get('/listings/{id}', 'ListingController@show');
$router->get('/listings/edit/{id}', 'ListingController@edit');

$router->post('/listings', 'ListingController@store');
$router->delete('/listings/{id}', 'ListingController@destroy');
$router->put('/listings/update/{id}', 'ListingController@update');

$router->get('/auth/register', 'UserController@register');
$router->post('/auth/register', 'UserController@registerUser');
$router->get('/auth/login', 'UserController@login');
$router->post('/auth/login', 'UserController@loginUser');
