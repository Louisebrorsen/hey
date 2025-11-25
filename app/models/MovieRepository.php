<?php

class MovieRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    
    public function getAll(): array
    {
        $sql = "SELECT * FROM movie ORDER BY title"; 
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getNowPlaying(): array
    {
    
        $sql = "SELECT * FROM movie WHERE released<=CURDATE()"; 

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getComingSoon(): array
    {
        
        $sql = "SELECT * FROM movie WHERE released>CURDATE()"; 

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

   
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM movie WHERE movieID = :id"; 

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        return $movie ?: null;
    }

    public function create(array $data): int
    {
        $title = trim($data['title'] ?? '');
        if ($title === '') {
            return 0;
        }

        $released = trim($data['released'] ?? '');
        $released = $released !== '' ? $released : null;

        $sql = "INSERT INTO movie (title, poster_url, description, released, duration_min, age_limit)
                VALUES (:title, :poster, :descr, :released, :duration, :age)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title'    => $title,
            ':poster'   => $data['poster_url'] ?? null,
            ':descr'    => $data['description'] ?? null,
            ':released' => $released,
            ':duration' => (int)($data['duration_min'] ?? 0),
            ':age'      => (int)($data['age_limit'] ?? 0),
        ]);

        return (int)$this->pdo->lastInsertId();
    }
}