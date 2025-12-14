<?php
class NewsRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllNews(?int $limit = null): array
{
    $sql = "SELECT * FROM news ORDER BY published_date DESC";

    if ($limit !== null) {
        $sql .= " LIMIT :limit";
    }

    $stmt = $this->pdo->prepare($sql);

    if ($limit !== null) {
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    }

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function createNews(string $title, string $content): void
    {
        $sql = "INSERT INTO news (title, content, published_date) VALUES (:title, :content, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':content', $content, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function deleteNews(int $newsID): void
    {
        $sql = "DELETE FROM news WHERE newsID = :newsID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':newsID', $newsID, PDO::PARAM_INT);
        $stmt->execute();
    }
}