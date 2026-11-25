<?php
require_once __DIR__ . '/Database.php';

class User
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    // Email ager theke ache kina
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    // Notun user toiri (password hash kore)
    public function create(string $name, string $email, string $password): bool
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );
        return $stmt->execute([$name, $email, $hash]);
    }

    // Email diye user khuje ber kora (login e lagbe)
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
    
    // Login check: email ar password thik kina
    public function verifyLogin(string $email, string $password): ?array
    {
        $user = $this->findByEmail($email);

        // password_verify() hash er sathe asol password milay
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return null;
    }
}