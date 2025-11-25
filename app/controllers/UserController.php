<?php
class UserController
{
    private AuthService $auth;

    public function __construct()
    {
    
        $pdo = Database::connect();
        $this->auth = new AuthService($pdo);
    }

  
    public function profile(): array
    {
        
        if (!$this->auth->isLoggedIn() || empty($_SESSION['user'])) {
            header("Location: ?url=login");
            exit;
        }

       
        $user = $_SESSION['user'];

        return [
            'view' => __DIR__ . '/../views/profile.php',
            'data' => [
                'user' => $_SESSION['user'],
            ],
        ];
    }


}
 

