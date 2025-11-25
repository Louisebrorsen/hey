<?php

class Movie
{
    public static function all(): array
    {
        $db = Database::connect();

        $stmt = $db->query("SELECT * FROM movie");
        return $stmt->fetchAll();
    }

    public static function movies_all(): array
    {
        return self::all(); 
    }

    public static function find(int $id): ?array
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM movie WHERE movieid = :id");
        $stmt->execute(['id' => $id]);

        $movie = $stmt->fetch();
        return $movie ?: null;
    }

    public static function nowPlaying(?int $limit = null): array
    {
        $db = Database::connect();

        $sql = "SELECT *
                FROM movie
                WHERE released <= CURDATE()
                AND released >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY released DESC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $db->prepare($sql);

        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function comingSoon(?int $limit = null): array
    {
        $db = Database::connect();

        $sql = "SELECT *
                FROM movie
                WHERE released > CURDATE()
                ORDER BY released ASC";

        if ($limit !== null) {
            $sql .= " LIMIT :limit";
        }

        $stmt = $db->prepare($sql);

        if ($limit !== null) {
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

   
}