<?php
class AuditoriumRepository {
    private PDO $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function create(string $name): int {
        $stmt = $this->pdo->prepare("INSERT INTO auditorium (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);
        return (int)$stmt->lastInsertId();
    }

    public function getAll(): array {
        $stmt = $this->pdo->query("SELECT * FROM auditorium ORDER BY auditoriumID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}