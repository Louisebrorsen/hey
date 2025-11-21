<?php

// Forsiden og liste over film
$router->get('', 'HomeController@index');
$router->get('movies', 'MovieController@index');
$router->get('admin','AdminController@index');
$router->post('contact/send', 'ContactController@send');
// Detalje-side for én film
$router->get('movieDetail', 'MovieController@show');

//admin router 
$router->get('admin', 'AdminController@index');
