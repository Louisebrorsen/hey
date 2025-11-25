<?php

class AdminActionsController
{
    private AuthService $auth;
    private MovieRepository $movieRepo;
    private ScreeningRepository $screeningRepo;

    public function __construct()
    {
        $db = Database::connect();

        $this->auth = new AuthService($db);
        if (!$this->auth->isAdmin()) {
            header("Location: ?url=login");
            exit;
        }

        $this->movieRepo     = new MovieRepository($db);
        $this->screeningRepo = new ScreeningRepository($db);
    }

    
    public function createMovie(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin');
            exit;
        }

        

        $id = $this->movieRepo->create($_POST);

        if ($id > 0) {
            $_SESSION['message'] = 'Filmen blev oprettet.';
        } else {
            $_SESSION['message'] = 'Filmen kunne ikke oprettes – mangler titel?';
        }

      
        header('Location: ?url=admin');
        exit;
    }

    // Her kan du senere tilføje:
    // public function deleteMovie(): void { ... }
    // public function updateMovie(): void { ... }
    // public function createShowtime(): void { ... }
    // osv.
}