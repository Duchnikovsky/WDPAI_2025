<?php

class User
{
    private $email;
    private $passwordHash;
    private $role;

    public function __construct($email, $password, $role = 'USER')
    {
        $this->email = $email;
        $this->setPassword($password);
        $this->role = $role;
    }

    public static function fromDatabase($email, $passwordHash, $role = 'USER')
    {
        $instance = new self($email, '', $role);
        $instance->passwordHash = $passwordHash;
        return $instance;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setPassword($password)
    {
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->passwordHash);
    }
}
