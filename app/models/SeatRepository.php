<?php

class SeatRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /** Hent alle sæder til en specificeret sal */
    public function getByAuditorium(int $auditoriumID): array
    {
        $sql = "SELECT * FROM seat WHERE auditoriumID = :id ORDER BY rowNo, seatNo";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $auditoriumID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Slet ALLE sæder i en sal (bruges når man regenererer) */
    public function deleteByAuditorium(int $auditoriumID): void
    {
        $sql = "DELETE FROM seat WHERE auditoriumID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $auditoriumID]);
    }

    /** Opret et enkelt sæde */
    public function create(int $auditoriumID, int $row, int $seatNumber): int
    {
        $sql = "INSERT INTO seat (auditoriumID, rowNo, seatNo)
                VALUES (:aud, :r, :s)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':aud' => $auditoriumID,
            ':r'   => $row,
            ':s'   => $seatNumber,
        ]);

        return (int)$this->pdo->lastInsertId();
    }
    public function getReservedSeatIdsByScreening(int $screeningID): array
{
    $sql = "SELECT seatID FROM seatReservation WHERE screeningID = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $screeningID]);

    return array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'seatID');
}
}