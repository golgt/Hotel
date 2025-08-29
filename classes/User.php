<?php

class User {

    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getUserById($userId) {
        $stmt = $this->pdo->prepare("SELECT name, lastname, email, loyalty_points FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch();
    }

    public function updateUser($userId, $name, $lastname, $email, $password = null) {
        if ($password) {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $lastname, $email, $passwordHash, $userId]);
        } else {
            $stmt = $this->pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $lastname, $email, $userId]);
        }
    }
}
