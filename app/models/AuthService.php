<?php
class AuthService{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function login(string $email, string $password)
    {
        $stmt = $this->pdo->prepare("
            SELECT userID, firstName, lastName, email, password, role
            FROM user
            WHERE email = :email
            LIMIT 1
        ");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        $_SESSION['user'] = [
            'userID'    => (int) $user['userID'],
            'firstName' => $user['firstName'] ?? '',
            'lastName'  => $user['lastName'] ?? '',
            'email'     => $user['email'] ?? '',
            'role'      => $user['role'] ?? 'user',
        ];

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