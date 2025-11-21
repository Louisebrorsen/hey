
<?php

class ScreeningRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Hent visninger for en bestemt film (til movieDetail)
    public function getByMovie(int $movieId): array
    {
        // TILPAS tabeller + kolonnenavne!
        $sql = "
            SELECT *
            FROM screening
            WHERE movieID = :movie_id
            ORDER BY screening_time
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':movie_id', $movieId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}