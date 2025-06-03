<?php

require_once 'Repository.php';

class CategoryRepository extends Repository
{
    public function getAll(): array
    {
        $conn = $this->db->connect();
        $stmt = $conn->query("SELECT name, icon FROM categories ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
