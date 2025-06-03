<?php

require_once 'Repository.php';

class BookRepository extends Repository
{
    public function getBooks(int $page, int $limit, string $search): array
    {
        $offset = ($page - 1) * $limit;
        $conn = $this->db->connect();

        $searchTerm = "%$search%";
        $stmt = $conn->prepare("
            SELECT b.title, b.author, c.name AS category, COALESCE(SUM(bs.quantity), 0) AS quantity
            FROM books b
            JOIN categories c ON b.category_id = c.id
            LEFT JOIN book_stock bs ON b.id = bs.book_id
            WHERE b.title ILIKE :search OR b.author ILIKE :search
            GROUP BY b.id, c.name
            ORDER BY b.title ASC
            LIMIT :limit OFFSET :offset
        ");

        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countBooks(string $search): int
    {
        $conn = $this->db->connect();
        $searchTerm = "%$search%";

        $stmt = $conn->prepare("
            SELECT COUNT(*) FROM books 
            WHERE title ILIKE :search OR author ILIKE :search
        ");
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();

        return (int) $stmt->fetchColumn();
    }
}
