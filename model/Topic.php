<?php

class Topic {

    public static function getAll() {
        global $pdo;
        $stmt = $pdo->query("SELECT * FROM topics ORDER BY name ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}