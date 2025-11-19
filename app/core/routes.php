<?php

// Forsiden og liste over film
$router->get('', 'MovieController@index');
$router->get('movies', 'MovieController@index');
$router->get('admin','AdminController@index');
$router->post('contact/send', 'ContactController@send');
// Detalje-side for én film
$router->get('movie', 'MovieController@show');