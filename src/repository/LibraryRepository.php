<?php

require_once 'Repository.php';

class LibraryRepository extends Repository
{
    public function getAll()
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT id, name, address FROM libraries ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByName(string $name): ?array
    {
        $stmt = $this->db->connect()->prepare("SELECT * FROM libraries WHERE name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
