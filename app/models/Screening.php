<?php


class Screening
{
    public static function findByMovie(int $movieId): array
    {
        $db = Database::connect();

       $sql = "
        SELECT * 
        FROM screening 
        WHERE movieID = :movie
        ORDER BY screening_time ASC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute(['movie' => $movieId]);

        return $stmt->fetchAll();
    }
}