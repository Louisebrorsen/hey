<?php
class ScreeningRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllScreeningsWithDetails(): array
    {
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

    public function createScreening(int $movieID, int $auditoriumID, string $screeningTime, float $price): bool
    {
        $sql = "
        INSERT INTO screening (movieID, auditoriumID, screening_time, price)
        VALUES (:movieID, :auditoriumID, :screening_time, :price)
    ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([
                ':movieID'        => $movieID,
                ':auditoriumID'   => $auditoriumID,
                ':screening_time' => $screeningTime,
                ':price'          => $price,
            ]);

            return true; // oprettet
        } catch (\PDOException $e) {
            // 23000 = integrity constraint violation (fx UNIQUE constraint brud)
            if ($e->getCode() === '23000') {
                return false; // dobbeltbooking / unik-brud
            }

            // alt andet er en "rigtig" fejl → smid videre
            throw $e;
        }
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

    public function deleteScreening(int $id): bool
    {
        $sql = "DELETE FROM screening WHERE screeningID = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function getTodayScreenings(): array
    {
        $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            m.title AS movie_title,
            a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        WHERE DATE(s.screening_time) = CURDATE()
        ORDER BY s.screening_time ASC
        ";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getScreeningById(int $id): ?array
{
    $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            s.movieID,
            s.auditoriumID,
            m.title AS movie_title,
            a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        WHERE s.screeningID = :id
    ";
    $stmt = $this->db->prepare($sql);
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result ?: null;
}

    public function getUpcomingScreeningsWithDetails(): array
{
    $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            m.title AS movie_title,
            a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        WHERE s.screening_time >= NOW()
        ORDER BY s.screening_time ASC
    ";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function getPasttScreeningsWithDetails(): array
{
    $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            m.title AS movie_title,
            a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        WHERE s.screening_time < NOW()
        ORDER BY s.screening_time DESC
    ";

    $stmt = $this->db->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}