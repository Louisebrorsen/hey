<?php

class InvoiceRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Henter faktura/kvitterings-data for en reservation.
     * Returnerer én samlet array med header-data + seats som liste.
     */
    public function getInvoiceByReservationId(int $reservationID): ?array
    {
        // 1) Header-data (reservation + screening + movie + auditorium)
        $sql = "
            SELECT
                r.reservationID,
                r.reservation_date,
                r.adults,
                r.children,
                r.seniors,
                r.total_price,

                s.screeningID,
                s.start_time,
                s.price,

                m.title,
                m.poster_url,

                a.auditoriumNo
            FROM reservation r
            JOIN screening s   ON s.screeningID = r.screeningID
            JOIN movie m       ON m.movieID     = s.movieID
            JOIN auditorium a  ON a.auditoriumID = s.auditoriumID
            WHERE r.reservationID = :id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $reservationID]);
        $invoice = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$invoice) {
            return null;
        }

        // 2) Sæder til reservationen
        $seatSql = "
            SELECT se.rowNo, se.seatNo
            FROM seatReservation sr
            JOIN seat se ON se.seatID = sr.seatID
            WHERE sr.reservationID = :id
            ORDER BY se.rowNo, se.seatNo
        ";

        $seatStmt = $this->pdo->prepare($seatSql);
        $seatStmt->execute([':id' => $reservationID]);
        $seats = $seatStmt->fetchAll(PDO::FETCH_ASSOC);

        $invoice['seats'] = $seats;

        return $invoice;
    }
}
