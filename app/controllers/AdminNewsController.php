<?php
class AdminNewsController
{
    private AuthService $auth;
    private NewsRepository $newsRepo;

    public function __construct()
    {
        $db = Database::connect();
        $this->auth = new AuthService($db);
        $this->newsRepo = new NewsRepository($db);

        // Admin protection
        if (!$this->auth->isAdmin()) {
            header("Location: ?url=login");
            exit;
        }
    }

    public function create(): void
    {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';

        $this->newsRepo->createNews($title, $content);

        header("Location: ?url=admin/cinemaNews");
        exit;
    }

    public function delete(): void
    {
        $newsID = isset($_POST['newsID']) ? (int)$_POST['newsID'] : 0;

        if ($newsID > 0) {
            $this->newsRepo->deleteNews($newsID);
        }

        header("Location: ?url=admin/cinemaNews");
        exit;
    }
}