<?php

class NewsController
{
    private NewsRepository $newsRepo;

    public function __construct()
    {
        $db = Database::connect();
        $this->newsRepo = new NewsRepository($db);
    }

    public function index(): array
    {
        // Hent alle nyheder (eller kun publicerede, afhængigt af din repo)
        $news = $this->newsRepo->getAllNews();

        return [
            'view' => __DIR__ . '/../views/news.php',
            'data' => [
                'news' => $news,
            ],
        ];
    }
}