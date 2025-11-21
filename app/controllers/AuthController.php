<?php

class AuthController{

    private AuthService $auth;

    public function __construct()
    {
        $db = Database::connect();
        $this->auth = new AuthService($db);
    }

    public function showLogin(): array
    {
        return [
            'view' => __DIR__ . '/../views/auth/login.php',
            'data' => [],
        ];
    }

    public function login(): array
    {
       if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = ($_POST['password'] ?? '');

            if ($this->auth->login($email, $password)) {
               if($this->auth->isAdmin()){
                   header('Location: ?url=admin');
                   exit;
               } else {
                   header('Location: ?url=');
                   exit;
               }
           }
           $_SESSION['flash_error'] = "Forkert email eller adgangskode.";
            header("Location: ?url=login");
            exit;
       }
       
        return $this->showLogin(); 
    }
    public function logout(): void
    {
        $this->auth->logout();
        header('Location: ?url=');
        exit;
    }
}