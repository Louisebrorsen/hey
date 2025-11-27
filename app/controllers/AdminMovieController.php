<?php
class AdminMovieController
{
    private MovieRepository $movieRepo;

    public function __construct()
    {
        $db = Database::connect();
        $this->movieRepo = new MovieRepository($db);
    }

    public function index(): array
    {
        $movies = $this->movieRepo->getAll();

        return [
            'view' => __DIR__ . '/../views/admin/movies.php',
            'data' => ['movies' => $movies],
        ];
    }

    public function edit()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        if ($id <= 0) {
            $_SESSION['message'] = 'Ugyldigt film-ID.';
            header('Location: ?url=admin/allMovies');
            exit;
        }
        $movie = $this->movieRepo->getById($id);
        if (!$movie) {
            $_SESSION['message'] = 'Filmen blev ikke fundet.';
            header('Location: ?url=admin/allMovies');
            exit;
        }
        return [
            'view' => __DIR__ . '/../views/admin/movieEdit.php',
            'data' => ['movie' => $movie]
        ];
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=admin/allMovies');
            exit;
        }
        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            $_SESSION['message'] = 'Ugyldigt film-ID.';
            header('Location: ?url=admin/allMovies');
            exit;
        }
        $movie = $this->movieRepo->getById($id);
        if (!$movie) {
            $_SESSION['message'] = 'Filmen findes ikke længere.';
            header('Location: ?url=admin/allMovies');
            exit;
        }
        $title = trim($_POST['title'] ?? '');
        $runtime = isset($_POST['duration_min']) ? (int)$_POST['duration_min'] : 0;
        if ($title === '' || $runtime <= 0) {
            $_SESSION['message'] = 'Titel og spilletid skal udfyldes.';
            header('Location: ?url=admin/movie/edit&id=' . $id);
            exit;
        }
        // Keep existing poster always (edit does not change poster)
        $posterRel = $movie['poster_url'];
        $data = [
            'title'        => $title,
            'poster_url'   => $posterRel,
            'description'  => trim($_POST['description'] ?? ''),
            'released'     => trim($_POST['released'] ?? ''),
            'duration_min' => $runtime,
            'age_limit'    => (int)($_POST['age_limit'] ?? 0),
        ];
        try {
            $ok = $this->movieRepo->update($id, $data);
            if ($ok) {
                $_SESSION['message'] = 'Filmen blev opdateret.';
            } else {
                $_SESSION['message'] = 'Filmen kunne ikke opdateres.';
            }
        } catch (Throwable $e) {
            $_SESSION['message'] = 'DB-fejl: ' . $e->getMessage();
        }
        header('Location: ?url=admin/allMovies');
        exit;
    }


    public function delete()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        header('Location: ?url=admin/allMovies');
        exit;
    }

    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($id <= 0) {
        $_SESSION['message'] = 'Ugyldigt ID.';
        header('Location: ?url=admin/allMovies');
        exit;
    }

    try {
        $this->movieRepo->delete($id);
        $_SESSION['message'] = 'Filmen blev slettet.';
    } catch (Throwable $e) {
        $_SESSION['message'] = 'Kunne ikke slette: ' . $e->getMessage();
    }

    header('Location: ?url=admin/allMovies');
    exit;
}

}