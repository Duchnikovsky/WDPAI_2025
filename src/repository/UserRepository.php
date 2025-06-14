<?php

require_once 'Repository.php';
require_once __DIR__ . '/../models/User.php';

class UserRepository extends Repository
{

    public function getUserByEmail(string $email): ?User
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT * FROM public.users WHERE email = :email');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            return User::fromDatabase($user['email'], $user['password'], $user['role']);
        }

        return null;
    }

    public function saveUser(User $user): void
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('INSERT INTO public.users (email, password) VALUES (:email, :password)');
        $email = $user->getEmail();
        $passwordHash = $user->getPasswordHash();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function isAccessCodeValid(string $accessCode): bool
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('SELECT 1 FROM registration_codes WHERE code = :code');
        $stmt->bindParam(':code', $accessCode, PDO::PARAM_STR);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();
    }

    public function consumeAccessCode(string $accessCode): void
    {
        $conn = $this->db->connect();
        $stmt = $conn->prepare('DELETE FROM registration_codes WHERE code = :code');
        $stmt->bindParam(':code', $accessCode, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function generateUniqueCode(): string
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $exists = $this->db->connect()
                ->prepare("SELECT 1 FROM registration_codes WHERE code = :code");
            $exists->bindParam(':code', $code, PDO::PARAM_STR);
            $exists->execute();
        } while ($exists->fetch());

        return $code;
    }

    public function saveAccessCode(string $code): void
    {
        $stmt = $this->db->connect()->prepare("INSERT INTO registration_codes (code, created_at) VALUES (:code, NOW())");
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->execute();
    }
}
