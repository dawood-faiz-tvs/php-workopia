<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create', ['auth']);
$router->get('/listings/search', 'ListingController@search');
$router->get('/listings/{id}', 'ListingController@show');
$router->get('/listings/edit/{id}', 'ListingController@edit', ['auth']);

$router->post('/listings', 'ListingController@store', ['auth']);
$router->delete('/listings/{id}', 'ListingController@destroy', ['auth']);
$router->put('/listings/update/{id}', 'ListingController@update', ['auth']);

$router->get('/auth/register', 'UserController@register', ['guest']);
$router->post('/auth/register', 'UserController@registerUser');
$router->get('/auth/login', 'UserController@login', ['guest']);
$router->post('/auth/login', 'UserController@authenticate');
$router->post('/auth/logout', 'UserController@logout', ['auth']);
