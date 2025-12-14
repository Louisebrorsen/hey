<?php

class AdminInvoiceController
{
    private InvoiceRepository $invoiceRepo;

    public function __construct()
    {
        $db = Database::connect();
        $this->invoiceRepo = new InvoiceRepository($db);
    }

    public function show(): array
    {
        $reservationID = (int)($_GET['reservationID'] ?? 0);

        if ($reservationID <= 0) {
            http_response_code(400);
            die('Missing reservationID');
        }

        $invoice = $this->invoiceRepo->getInvoiceByReservationId($reservationID);

        if (!$invoice) {
            http_response_code(404);
            die('Reservation not found');
        }

        return [
            'view' => __DIR__ . '/../views/admin/invoice.php',
            'data' => [
                'invoice' => $invoice,
            ],
        ];
    }
}