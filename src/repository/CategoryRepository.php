<?php

require_once 'Repository.php';

class CategoryRepository extends Repository
{
    public function getAll(): array
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT id, name, icon FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByName(string $name): ?array
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare("
        SELECT id, name, icon FROM categories 
            WHERE name = :name LIMIT 1
        ");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function addCategory(string $name, string $icon): int
    {
        $conn = $this->db->connect();

        $stmt = $conn->prepare("
        INSERT INTO categories (name, icon)
        VALUES (:name, :icon)
        RETURNING id
    ");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':icon', $icon);
        $stmt->execute();

        return $stmt->fetchColumn();
    }
}
