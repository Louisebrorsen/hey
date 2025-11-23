<?php
  
class UserController
{
    private AuthService $auth;

    public function __construct()
    {
        // Opret forbindelse til databasen og AuthService
        $pdo = Database::connect();
        $this->auth = new AuthService($pdo);
    }

    /**
     * Viser profilsiden for den aktuelt loggede bruger
     */
    public function profile(): array
    {
        // Kræv login – ellers send brugeren til login-siden
        if (!$this->auth->isLoggedIn() || empty($_SESSION['user'])) {
            header("Location: ?url=login");
            exit;
        }

        // Hent brugerdata fra session
        $user = $_SESSION['user'];

        return [
            'view' => __DIR__ . '/../views/profile.php',
            'data' => [
                'user' => $_SESSION['user'],
            ],
        ];
    }
}
 

