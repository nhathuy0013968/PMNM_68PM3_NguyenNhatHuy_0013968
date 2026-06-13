<?php

class UserModel
{
    private PDO $db;

    public function __construct()
    {
        $connectDB = new ConnectDB();
        $this->db = $connectDB->connect();
    }

    public function findByUsername(string $username): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);

        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->findByUsername($username);

        if (!$user) {
            return null;
        }

        $storedPassword = (string) $user['password'];
        $isValid = password_verify($password, $storedPassword) || hash_equals($storedPassword, $password);

        return $isValid ? $user : null;
    }
}
