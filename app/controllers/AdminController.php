<?php
 class AdminController
{
    private MovieRepository $movieRepo;
    private ScreeningRepository $screeningRepo;
    private AuthService $auth;

    public function __construct()
    {
        $db = Database::connect(); 

        $this->auth = new AuthService($db);

        // Admin protection
        if (!$this->auth->isAdmin()) {
            header("Location: ?url=login");
            exit;
        }

        $this->movieRepo     = new MovieRepository($db);
        $this->screeningRepo = new ScreeningRepository($db);
    }

    public function index(): array
    {
        $tab = $_GET['tab'] ?? 'movies';
        $data = [
            'tab' => $tab,
        ];

        switch ($tab) {
            case 'movies':
                $data['movies'] = $this->movieRepo->getAll();
                break;

            case 'showings':
                // $data['showings'] = $this->screeningRepo->getAll();
                break;

            case 'rooms':
                // $data['rooms'] = $this->roomRepo->getAll();
                break;

            case 'company':
                // $data['company'] = $this->companyRepo->getInfo();
                break;
        }

        return [
            'view' => __DIR__ . '/../views/admin/admin.php',
            'data' => $data,
        ];
    }
}