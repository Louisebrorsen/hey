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
        // Vi vælger r.* så vi ikke crasher, hvis kolonnenavne varierer (fx qty_adult vs adults)
        $sql = "
            SELECT
                r.*,
                s.*,
                m.title,
                m.poster_url,
                a.*
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

        // Normaliser feltnavne så viewet altid kan bruge de samme keys
        $invoice['adults']  = (int)($invoice['adults'] ?? $invoice['qty_adult'] ?? $invoice['adult_tickets'] ?? 0);
        $invoice['children'] = (int)($invoice['children'] ?? $invoice['qty_child'] ?? $invoice['child_tickets'] ?? 0);
        $invoice['seniors'] = (int)($invoice['seniors'] ?? $invoice['qty_senior'] ?? $invoice['senior_tickets'] ?? 0);

        $invoice['total_price'] = (float)($invoice['total_price'] ?? $invoice['totalPrice'] ?? $invoice['total'] ?? $invoice['amount'] ?? 0);

        // reservation_date kan hedde forskelligt – fallback til created_at eller NOW
        $invoice['reservation_date'] = $invoice['reservation_date'] ?? $invoice['created_at'] ?? $invoice['reservationDate'] ?? date('Y-m-d H:i:s');

        // Normaliser screening start-tid (kolonnenavn varierer typisk mellem projekter)
        $invoice['start_time'] = $invoice['start_time']
            ?? $invoice['screening_time']
            ?? $invoice['screeningTime']
            ?? $invoice['startTime']
            ?? $invoice['datetime']
            ?? $invoice['date_time']
            ?? $invoice['screening_date']
            ?? $invoice['screeningDate']
            ?? $invoice['screeningDateTime']
            ?? null;

        // Normaliser sal-nummer/navn (kolonnenavn varierer: auditoriumNo, number, hall_no, roomNo, name, osv.)
        $invoice['auditoriumNo'] = $invoice['auditoriumNo']
            ?? $invoice['auditorium_no']
            ?? $invoice['auditorium_number']
            ?? $invoice['number']
            ?? $invoice['hall']
            ?? $invoice['hallNo']
            ?? $invoice['roomNo']
            ?? $invoice['room_no']
            ?? $invoice['name']
            ?? null;

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
