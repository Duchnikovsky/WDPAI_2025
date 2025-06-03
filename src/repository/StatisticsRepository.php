<?php

require_once 'Repository.php';

class StatisticsRepository extends Repository
{
    public function getMonthlyBestsellers(int $limit = 10): array
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("
            SELECT 
                b.title,
                b.author,
                c.name AS category,
                COUNT(r.id) AS reservations_count
            FROM reservations r
            JOIN books b ON r.book_id = b.id
            JOIN categories c ON b.category_id = c.id
            WHERE r.reserved_at >= NOW() - INTERVAL '1 month'
            GROUP BY b.id, c.name
            ORDER BY reservations_count DESC
            LIMIT :limit
        ");
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
