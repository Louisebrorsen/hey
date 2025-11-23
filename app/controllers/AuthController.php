<?php

class AuthController
{

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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
                $_SESSION['flash_error'] = "Ugyldig formular, prøv igen.";
                header("Location: ?url=login");
                exit;
            }
            $email = trim($_POST['email'] ?? '');
            $password = ($_POST['password'] ?? '');

            if ($this->auth->login($email, $password)) {
                if ($this->auth->isAdmin()) {
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

    public function showRegister(): array
    {
        return [
            'view' => __DIR__ . '/../views/register.php',
            'data' => [
                'member' => [
                    'firstName' => '',
                    'lastName'  => '',
                    'email'     => '',
                    'DOB'       => '',
                    'gender'    => '',
                    'password'  => '',
                    'confirm'   => '',
                ],
                'errors' => [],
                'result' => null,
            ],
        ];
    }

    public function register(): array
    {
        // Forudfyld member-array med POST-data (eller tomme værdier første gang)
        $member = [
            'firstName' => trim($_POST['firstName'] ?? ''),
            'lastName'  => trim($_POST['lastName'] ?? ''),
            'email'     => trim($_POST['email'] ?? ''),
            'DOB'       => $_POST['DOB'] ?? '',
            'gender'    => $_POST['gender'] ?? '',
        ];
        $errors = [];
        $result = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // CSRF-tjek (samme som i login)
            if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
                $_SESSION['flash_error'] = "Ugyldig formular, prøv igen.";
                header("Location: ?url=register");
                exit;
            }

            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm'] ?? '';

            // Simpel validering
            if ($member['firstName'] === '') {
                $errors['firstName'] = 'Fornavn er påkrævet';
            }
            if ($member['lastName'] === '') {
                $errors['lastName'] = 'Efternavn er påkrævet';
            }
            if (!filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Ugyldig email.';
            }
            if (strlen($password) < 8) {
                $errors['password'] = 'Adgangskode skal være mindst 8 tegn.';
            }
            if ($password !== $confirm) {
                $errors['confirm'] = 'Adgangskoderne matcher ikke.';
            }

            if (!$errors) {
                $pdo = Database::connect();

                // Tjek om email allerede findes
                $stmt = $pdo->prepare("SELECT userID FROM user WHERE email = :email");
                $stmt->execute(['email' => $member['email']]);
                if ($stmt->fetch()) {
                    $errors['email'] = 'Der findes allerede en bruger med den email.';
                } else {
                    // Opret ny bruger – matcher din tabel: userID, lastName, firstName, DOB, email, password, gender
                    $stmt = $pdo->prepare("
                        INSERT INTO user (lastName, firstName, DOB, email, password, gender)
                        VALUES (:lastName, :firstName, :DOB, :email, :password, :gender)
                    ");
                    $stmt->execute([
                        'lastName'  => $member['lastName'],
                        'firstName' => $member['firstName'],
                        'DOB'       => $member['DOB'] !== '' ? $member['DOB'] : null,
                        'email'     => $member['email'],
                        'password'  => password_hash($password, PASSWORD_DEFAULT),
                        'gender'    => $member['gender'] ?: null,
                    ]);

                    // Log brugeren ind og redirect efter succesfuld oprettelse
                    $this->auth->login($member['email'], $password);
                    header('Location: ?url=');
                    exit;
                }
            }
        }

        // Hvis der er fejl eller det er første visning af formularen
        return [
            'view' => __DIR__ . '/../views/register.php',
            'data' => [
                'member' => $member,
                'errors' => $errors,
                'result' => $result,
            ],
        ];
    }

    public function profile(): array
    {
        if (!$this->auth->isLoggedIn()) {
            header("Location: ?url=login");
            exit;
        }

        return [
            'view' => __DIR__ . '/../views/profile.php',
            'data' => []
        ];
    }
}
