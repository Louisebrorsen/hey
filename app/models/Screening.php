<?php

require_once __DIR__ . '/../core/Database.php';

class Screening
{
    public static function findByMovie(int $movieId): array
    {
        $db = Database::connect();

        $sql = "
            SELECT * 
            FROM screening 
            WHERE movieid = :movie
            ORDER BY starttime ASC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['movie' => $movieId]);

        return $stmt->fetchAll();
    }
}