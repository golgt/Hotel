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
    public function getUserByEmail(string $email): ?array {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        return $user ?: null;
    }
    public function registerUser($name, $lastname, $email, $password, $gender = 'male'): int{
        $stmt = $this->pdo->prepare("INSERT INTO users (name, lastname, email, password, loyalty_points, gender) VALUES (?, ?, ?, ?, 10, ?)");
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt->execute([$name, $lastname, $email, $passwordHash, $gender]);
        return (int) $this->pdo->lastInsertId();
    }

    public function updateUser($userId, $name, $lastname, $email, $password = null) {
        if ($password) {
            // Aktualizácia s novým heslom
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $this->pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $lastname, $email, $passwordHash, $userId]);
        } else {
            // Aktualizácia bez zmeny hesla
            $stmt = $this->pdo->prepare("UPDATE users SET name = ?, lastname = ?, email = ? WHERE id = ?");
            $stmt->execute([$name, $lastname, $email, $userId]);
        }
    }
}
