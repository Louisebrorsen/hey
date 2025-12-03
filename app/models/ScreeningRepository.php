<?php
class ScreeningRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function getAllScreeningsWithDetails(): array {
    $sql = "
        SELECT s.screeningID,
               s.screening_time,
               s.price,
               m.title AS movie_title,
               a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        ORDER BY s.screening_time ASC
    ";
    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public function createScreening(int $movieID, int $auditoriumID, string $screening_time, float $price): bool {
        $sql = "
            INSERT INTO screening (movieID, auditoriumID, screening_time, price)
            VALUES (:movieID, :auditoriumID, :screening_time, :price)
        ";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':movieID' => $movieID,
            ':auditoriumID' => $auditoriumID,
            ':screening_time' => $screening_time,
            ':price' => $price
        ]);
    }

    public function getByMovie(int $movieID): array
    {
        $sql = "
            SELECT s.screeningID,
                   s.screening_time,
                   s.price,
                   a.name AS auditorium_name
            FROM screening s
            JOIN auditorium a ON s.auditoriumID = a.auditoriumID
            WHERE s.movieID = :movieID
            ORDER BY s.screening_time ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':movieID' => $movieID]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function hasConflict(int $auditoriumID, string $screeningTime): bool
{
    $sql = "
        SELECT COUNT(*) 
        FROM screening
        WHERE auditoriumID = :auditoriumID
          AND screening_time = :screening_time
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        ':auditoriumID'   => $auditoriumID,
        ':screening_time' => $screeningTime,
    ]);

    return (bool) $stmt->fetchColumn();
}

    
}