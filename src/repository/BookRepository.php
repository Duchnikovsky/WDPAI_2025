<?php

require_once 'Repository.php';

class BookRepository extends Repository
{
    public function getBooks(int $page, int $limit, string $search = '', string $category = ''): array
    {
        $offset = ($page - 1) * $limit;
        $conn = $this->db->connect();

        $searchTerm = "%$search%";

        $stmt = $conn->prepare("
        SELECT b.id, b.title, b.author, c.name AS category, COALESCE(SUM(bs.quantity), 0) AS quantity
        FROM books b
        JOIN categories c ON b.category_id = c.id
        LEFT JOIN book_stock bs ON b.id = bs.book_id
        WHERE 
            (b.title ILIKE :search OR b.author ILIKE :search)
            AND (c.name ILIKE :category OR :category = '')
        GROUP BY b.id, c.name
        ORDER BY b.title ASC
        LIMIT :limit OFFSET :offset
    ");

        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function countBooks(string $search = '', string $category = ''): int
    {
        $conn = $this->db->connect();

        $searchTerm = "%$search%";

        if (!empty($category)) {
            $stmt = $conn->prepare("
            SELECT COUNT(DISTINCT b.id) AS total
            FROM books b
            JOIN categories c ON b.category_id = c.id
            WHERE 
                (b.title ILIKE :search OR b.author ILIKE :search)
                AND c.name ILIKE :category
        ");
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
            $stmt->bindParam(':category', $category, PDO::PARAM_STR);
        } else {
            $stmt = $conn->prepare("
            SELECT COUNT(DISTINCT b.id) AS total
            FROM books b
            JOIN categories c ON b.category_id = c.id
            WHERE 
                (b.title ILIKE :search OR b.author ILIKE :search)
        ");
            $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        }

        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function findBookId(string $title, string $author, int $categoryId): ?int
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare("
        SELECT id FROM books 
        WHERE title = :title AND author = :author AND category_id = :category_id
        LIMIT 1
    ");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id'] : null;
    }

    public function addBook(string $title, string $author, int $categoryId): int
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare("
        INSERT INTO books (title, author, category_id)
        VALUES (:title, :author, :category_id)
        RETURNING id
    ");
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':author', $author);
        $stmt->bindParam(':category_id', $categoryId);
        $stmt->execute();

        return $stmt->fetchColumn();
    }

    public function addToLibrary(int $bookId, int $libraryId, int $quantity): void
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare("
        INSERT INTO book_stock (book_id, library_id, quantity)
        VALUES (:book_id, :library_id, :quantity)
        ON CONFLICT (book_id, library_id) DO UPDATE 
        SET quantity = book_stock.quantity + EXCLUDED.quantity
    ");
        $stmt->bindParam(':book_id', $bookId);
        $stmt->bindParam(':library_id', $libraryId);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }
}
