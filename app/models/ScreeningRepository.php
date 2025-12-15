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
               s.is_sold_out,
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
                   s.is_sold_out,
                   a.name AS auditorium_name
            FROM screening s
            JOIN auditorium a ON s.auditoriumID = a.auditoriumID
            WHERE s.movieID = :movieID
            AND s.screening_time >= NOW()
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
            s.is_sold_out,
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
            s.is_sold_out,
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
            s.is_sold_out,
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
            s.is_sold_out,
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

    public function getNextScreeningForMovie(int $movieID): ?array
    {
        $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            s.is_sold_out,
            a.name AS auditorium_name
        FROM screening s
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        WHERE s.movieID = :movieID
          AND s.screening_time >= NOW()
        ORDER BY s.screening_time ASC
        LIMIT 1
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':movieID' => $movieID]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function getScreeningByUser(int $userID): array
    {
        $sql = "
        SELECT 
            s.screeningID,
            s.screening_time,
            s.price,
            s.is_sold_out,
            m.title AS movie_title,
            a.name  AS auditorium_name
        FROM screening s
        JOIN movie m ON s.movieID = m.movieID
        JOIN auditorium a ON s.auditoriumID = a.auditoriumID
        JOIN reservation r ON s.screeningID = r.screeningID
        WHERE r.userID = :userID
        ORDER BY s.screening_time ASC
    ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userID' => $userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Henter de seneste reservationer for en bruger (til profilside).
     * Returnerer både reservation-data og screening/movie/auditorium detaljer.
     */
    public function getRecentBookingsByUser(int $userID, int $limit = 5): array
    {
        $limit = max(1, min(20, $limit)); // simple guard

        $sql = "
        SELECT
            r.reservationID,
            r.reservation_date,
            r.total_price,
            s.screeningID,
            s.screening_time,
            s.price AS screening_price,
            m.title AS movie_title,
            m.poster_url AS movie_poster_url,
            a.name  AS auditorium_name,
            CASE
                WHEN s.screening_time >= NOW() THEN 'Kommende'
                ELSE 'Afholdt'
            END AS status
        FROM reservation r
        JOIN screening s   ON r.screeningID = s.screeningID
        JOIN movie m       ON s.movieID = m.movieID
        JOIN auditorium a  ON s.auditoriumID = a.auditoriumID
        WHERE r.userID = :userID
        ORDER BY r.reservation_date DESC
        LIMIT $limit
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userID' => $userID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function getBookingStatsByUser(int $userID): array
    {
        $sql = "
        SELECT
            SUM(CASE WHEN s.screening_time >= NOW() THEN 1 ELSE 0 END) AS upcoming,
            SUM(CASE WHEN s.screening_time <  NOW() THEN 1 ELSE 0 END) AS past
        FROM reservation r
        JOIN screening s ON r.screeningID = s.screeningID
        WHERE r.userID = :userID
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':userID' => $userID]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'upcoming' => (int)($row['upcoming'] ?? 0),
            'past'     => (int)($row['past'] ?? 0),
        ];
    }
}
