<?php
class UserController
{
    private AuthService $auth;
    private ScreeningRepository $screeningRepository;

    public function __construct()
    {
    
        $pdo = Database::connect();
        $this->auth = new AuthService($pdo);
        $this->screeningRepository = new ScreeningRepository($pdo);
    }

  
    public function profile(): array
    {
        
        if (!$this->auth->isLoggedIn() || empty($_SESSION['user'])) {
            header("Location: ?url=login");
            exit;
        }

       
        $user = $_SESSION['user'];

        $userID = (int)($user['userID'] ?? $user['id'] ?? 0);

        $bookings = $userID ? $this->screeningRepository->getRecentBookingsByUser($userID, 5) : [];
        $bookingStats = $userID ? $this->screeningRepository->getBookingStatsByUser($userID) : ['upcoming' => 0, 'past' => 0];

        return [
            'view' => __DIR__ . '/../views/profile.php',
            'data' => [
                'user' => $_SESSION['user'],
                'bookings' => $bookings,
                'bookingStats' => $bookingStats,
            ],
        ];
    }


}
 
