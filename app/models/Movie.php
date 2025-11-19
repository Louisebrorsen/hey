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
        return self::all(); // eller brug din egen SQL
    }

    public static function find(int $id): ?array
    {
        $db = Database::connect();

        $stmt = $db->prepare("SELECT * FROM movie WHERE movieid = :id");
        $stmt->execute(['id' => $id]);

        $movie = $stmt->fetch();
        return $movie ?: null;
    }

    public static function nowPlaying(): array
    {
        $db = Database::connect();

        $sql = "SELECT * 
                FROM movie 
                WHERE released <= CURDATE()
                AND released >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
                ORDER BY released DESC";

        return $db->query($sql)->fetchAll();
    }

    public static function comingSoon(): array
    {
        $db = Database::connect();

        $sql = "SELECT * 
                FROM movie 
                WHERE released > CURDATE()
                ORDER BY released ASC";

        return $db->query($sql)->fetchAll();
    }
}