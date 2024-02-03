<?php
$router->get('/', 'HomeController@index');
$router->get('/listings', 'ListingController@index');
$router->get('/listings/create', 'ListingController@create');
$router->get('/listings/{id}', 'ListingController@show');
$router->delete('/listings/{id}', 'ListingController@destroy');
$router->post('/listings', 'ListingController@store');
