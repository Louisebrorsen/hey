<?php

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/helpers.php';  

// Models
require_once __DIR__ . '/../models/Movie.php';
require_once __DIR__ . '/../models/Screening.php';
require_once __DIR__ . '/../models/MovieRepository.php';
require_once __DIR__ . '/../models/ScreeningRepository.php';
require_once __DIR__ . '/../models/AuthService.php';
require_once __DIR__ . '/../models/AuditoriumRepository.php';
require_once __DIR__ . '/../models/SeatRepository.php';

// Controllers
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/MovieController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/ContactController.php';
require_once __DIR__ . '/../controllers/AuthController.php';
require_once __DIR__ . '/../controllers/UserController.php';
require_once __DIR__ . '/../controllers/AdminActionController.php';
require_once __DIR__ . '/../controllers/AdminMovieController.php';
require_once __DIR__ . '/../controllers/AdminRoomsController.php';
require_once __DIR__ . '/../controllers/AdminScreeningController.php';



