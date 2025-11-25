<?php

// Forsiden og liste over film
$router->get('', 'HomeController@index');
$router->get('movies', 'MovieController@index');
$router->post('contact/send', 'ContactController@send');

// Detalje-side for én film
$router->get('movieDetail', 'MovieController@show');

// login/logout routes
$router->get('login', 'AuthController@showLogin');
$router->post('login', 'AuthController@login');
$router->get('logout', 'AuthController@logout');

$router->get('register', 'AuthController@showRegister');
$router->post('register', 'AuthController@register');

$router->get('profile', 'UserController@profile');


// Admin tabs
$router->get('admin', 'AdminController@index');              // Film (standard)
$router->get('admin/rooms', 'AdminController@rooms');        // Sale & sæder
$router->get('admin/showtimes', 'AdminController@showtimes');// Showtimes
$router->get('admin/allMovies', 'AdminController@allMovies');// Alle film

//admin handlinger
$router->post('admin/movie/create', 'AdminActionsController@createMovie');