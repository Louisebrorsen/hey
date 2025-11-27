<?php

class MovieRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }


    public function getAll(): array
    {
        $sql = "SELECT * FROM movie ORDER BY title";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getNowPlaying(): array
    {

        $sql = "SELECT * FROM movie WHERE released<=CURDATE()";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getComingSoon(): array
    {

        $sql = "SELECT * FROM movie WHERE released>CURDATE()";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getById(int $id): ?array
    {
        $sql = "SELECT * FROM movie WHERE movieID = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $movie = $stmt->fetch(PDO::FETCH_ASSOC);

        return $movie ?: null;
    }

    public function create(array $data): int
    {
        $title       = trim((string)($data['title'] ?? ''));
        $releasedRaw = trim((string)($data['released'] ?? ''));
        $released    = $releasedRaw !== '' ? $releasedRaw : null;

        if ($title === '') {
            // midlertidig debug
            var_dump('TITLE TOM I REPO', $data);
            exit;
            // return 0;  // når vi er færdige med debug kan du skifte tilbage til den
        }

        $sql = "INSERT INTO movie (title, poster_url, description, released, duration_min, age_limit)
            VALUES (:title, :poster, :descr, :released, :duration, :age)";

        $stmt = $this->pdo->prepare($sql);

        try {
            $ok = $stmt->execute([
                ':title'    => $title,
                ':poster'   => $data['poster_url'] ?? null,
                ':descr'    => $data['description'] ?? null,
                ':released' => $released,
                ':duration' => (int)($data['duration_min'] ?? 0),
                ':age'      => (int)($data['age_limit'] ?? 0),
            ]);
        } catch (PDOException $e) {
            var_dump('PDO EXCEPTION', $e->getMessage());
            exit;
        }

        if (!$ok) {
            var_dump('SQL FEJL', $stmt->errorInfo());
            exit;
        }

        $id = (int)$this->pdo->lastInsertId();

        return $id;
    }
    public function createMovie(array $data): int
    {
        return $this->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $title       = trim((string)($data['title'] ?? ''));
        $releasedRaw = trim((string)($data['released'] ?? ''));
        $released    = $releasedRaw !== '' ? $releasedRaw : null;

        if ($title === '') {
            return false;
        }

        $sql = "UPDATE movie
            SET title = :title,
                poster_url = :poster,
                description = :descr,
                released = :released,
                duration_min = :duration,
                age_limit = :age
            WHERE movieID = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':title'    => $title,
            ':poster'   => $data['poster_url'] ?? '',
            ':descr'    => $data['description'] ?? null,
            ':released' => $released,
            ':duration' => (int)($data['duration_min'] ?? 0),
            ':age'      => (int)($data['age_limit'] ?? 0),
            ':id'       => $id,
        ]);
    }

    public function delete(int $id): bool
{
    $stmt = $this->pdo->prepare("DELETE FROM movie WHERE movieID = :id");
    return $stmt->execute([':id' => $id]);
}
}
