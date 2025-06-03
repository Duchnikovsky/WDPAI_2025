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
}
