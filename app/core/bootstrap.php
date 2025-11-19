<?php

require_once __DIR__ . '/Router.php';
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/helpers.php';  

// Controllers
require_once __DIR__ . '/../controllers/MovieController.php';
require_once __DIR__ . '/../controllers/AdminController.php';
require_once __DIR__ . '/../controllers/ContactController.php';

// Models
require_once __DIR__ . '/../models/Movie.php';
require_once __DIR__ . '/../models/Screening.php';
require_once __DIR__ . '/../models/Reservation.php';
require_once __DIR__ . '/../models/Seat.php';