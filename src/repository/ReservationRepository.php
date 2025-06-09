<?php

require_once 'Repository.php';

class ReservationRepository extends Repository
{
    public function makeReservation(int $bookId, int $libraryId, string $userEmail): string
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare("SELECT quantity FROM book_stock WHERE book_id = :book AND library_id = :lib");
        $stmt->execute([':book' => $bookId, ':lib' => $libraryId]);
        $quantity = (int) $stmt->fetchColumn();

        if ($quantity <= 0) {
            return false;
        }

        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';
        for ($i = 0; $i < 8; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $userEmail]);
        $userId = $stmt->fetchColumn();

        $stmt = $conn->prepare("
            INSERT INTO reservations (book_id, user_id, library_id, reservation_code)
            VALUES (:book, :user, :lib, :code)
        ");
        $stmt->execute([
            ':book' => $bookId,
            ':user' => $userId,
            ':lib' => $libraryId,
            ':code' => $code
        ]);

        $stmt = $conn->prepare("
            UPDATE book_stock
            SET quantity = quantity - 1
            WHERE book_id = :book AND library_id = :lib
        ");
        $stmt->execute([':book' => $bookId, ':lib' => $libraryId]);

        return $code;
    }
}
