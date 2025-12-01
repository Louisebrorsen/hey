<?php
class AuditoriumRepository
{
   
    /** @var PDO */
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function create(string $name): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO auditorium (name) VALUES (:name)");
        $stmt->execute([':name' => $name]);

        return (int)$this->pdo->lastInsertId();
    }

    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM auditorium ORDER BY auditoriumID");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM auditorium WHERE auditoriumID = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ?: null;
    }

    public function update(int $id, string $name): bool
    {
        $stmt = $this->pdo->prepare(
            "UPDATE auditorium SET name = :name WHERE auditoriumID = :id"
        );
        return $stmt->execute([
            ':name' => $name,
            ':id'   => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM auditorium WHERE auditoriumID = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function find(int $id): ?array
{
    $sql = "SELECT * FROM auditorium WHERE auditoriumID = :id";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([':id' => $id]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row ?: null;
}
}
