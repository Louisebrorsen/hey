<?php
class AdminScreeningController {
    private ScreeningRepository $screeningRepo;
    private MovieRepository $movieRepo;
    private AuditoriumRepository $auditoriumRepo;

    public function __construct(
        ScreeningRepository $screeningRepo,
        MovieRepository $movieRepo,
        AuditoriumRepository $auditoriumRepo
    ) {
        $this->screeningRepo = $screeningRepo;
        $this->movieRepo = $movieRepo;
        $this->auditoriumRepo = $auditoriumRepo;
    }

    public function index(): void {
        $screenings = $this->screeningRepo->getAllScreeningsWithDetails();
        $movies = $this->movieRepo->getAll();
        $auditoriums = $this->auditoriumRepo->getAll();

        require __DIR__ . '/../Views/admin/screenings.php';
    }

    public function store(): void {
        // simpelt eksempel på validering:
        $movieID = (int)($_POST['movieID'] ?? 0);
        $auditoriumID = (int)($_POST['auditoriumID'] ?? 0);
        $screening_time = $_POST['screening_time'] ?? '';
        $price = (float)($_POST['price'] ?? 0);

        // Her kunne du lave mere validering
        if ($movieID && $auditoriumID && $screening_time && $price > 0) {
            $this->screeningRepo->createScreening($movieID, $auditoriumID, $screening_time, $price);
        }

        // redirect tilbage til admin-listen
        header('Location: /admin/screenings');
        exit;
    }
}