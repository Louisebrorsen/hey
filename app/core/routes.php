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
$router->get('admin/showtimes', 'AdminController@showtimes'); // Showtimes
$router->get('admin/allMovies', 'AdminController@allMovies');// Alle film
$router->get('admin/cinemaInfo', 'AdminController@cinemaInfo'); // biograf informationer
$router->get('admin/cinemaNews', 'AdminController@cinemaNews'); // biograf nyheder

//admin handlinger movie
$router->post('admin/create', 'AdminActionsController@movieCreate');

$router->get('admin/movie/edit', 'AdminMovieController@edit');
$router->post('admin/movie/update', 'AdminMovieController@update');

$router->post('admin/movie/delete', 'AdminMovieController@delete');

//Sale og sæder
$router->post('admin/rooms/create', 'AdminRoomsController@create');
$router->get('admin/rooms/edit', 'AdminRoomsController@edit');
$router->post('admin/rooms/update', 'AdminRoomsController@update');
$router->post('admin/rooms/delete', 'AdminRoomsController@delete');
$router->post('admin/rooms/generateSeats', 'AdminRoomsController@generateSeats');
$router->get('admin/rooms/view', 'AdminRoomsController@view');

$router->get('admin/showtimes', 'AdminScreeningController@index');   
$router->post('admin/showtimes', 'AdminScreeningController@store');  
$router->post('admin/showtimes/delete', 'AdminScreeningController@delete');

//biograf informationer
$router->post('admin/cinemaInfo/update', 'AdminActionsController@cinemaInfoUpdate');

//biograf nyheder
$router->post('admin/cinemaNews/create', 'AdminCinemaNewsController@create');
$router->post('admin/cinemaNews/delete', 'AdminCinemaNewsController@delete');


// Booking routes
$router->get('booking', 'BookingController@show');
$router->post('booking', 'BookingController@bookSeats');

// bekræftelsesside efter booking
$router->get('booking/confirmation', 'BookingController@confirmation');