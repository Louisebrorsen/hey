<?php
class AuthService{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function login(string $email, string $password)
    {
        $stmt = $this->pdo->prepare("
            SELECT userID, firstName, lastName, email, password
            FROM user
            WHERE email = :email
            LIMIT 1
        ");
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
            'userID'    => (int) $user['userID'],
            'firstName' => $user['firstName'] ?? '',
            'lastName'  => $user['lastName'] ?? '',
            'email'     => $user['email'] ?? '',
            'role'      => $user['role'] ?? 'user',
        ];

        // For ekstra sikkerhed: giv session nyt id efter login
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }

        return true;
    }

    public function logout()
    {
        session_unset();
        session_destroy();
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user']);
    }
    public function isAdmin(): bool
    {
        return $this->isLoggedIn() && ($_SESSION['user']['role'] ?? '') === 'admin';
    }
}