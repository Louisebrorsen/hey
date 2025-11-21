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

    // Henter kommende film
    public function getComingSoon(): array
    {
        // TODO: skriv din egen logik/WHERE
        $sql = "SELECT * FROM movie WHERE released>CURDATE()"; 

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hent en enkelt film via id (til detaljesiden)
    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM movie WHERE movieID = :id"; // TILPAS kolonnenavn!

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        return $movie ?: null;
    }
}