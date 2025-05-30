<?php
class User {
    public static function findByUsername($username) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function exists($username, $email) {
        global $pdo;

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $username, 'email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($username, $name, $email, $password_hash) {
        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO users (username, name, email, password) 
                           VALUES (:username, :name, :email, :password)");
        $stmt->execute([
            'username' => $username,
            'name' => $name,
            'email' => $email,
            'password' => $password_hash
        ]);
    }

}
