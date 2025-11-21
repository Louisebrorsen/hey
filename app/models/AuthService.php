<?php
class AuthService{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function login(string $email, string $password)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM user WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Hvis ingen bruger blev fundet, returnér false
        if (!$user) {
            return false;
        }

        // Tjek om password matcher
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Login lykkedes: gem bruger-info i session
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'email' => $user['email'],
            'role'  => $user['role'] ?? 'user',
        ];

        // For ekstra sikkerhed: giv session nyt id efter login
        session_regenerate_id(true);

        return true;
    }
}