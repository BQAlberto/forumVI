<?php
class Post {
    public static function getByThread($threadID) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT posts.*, users.username 
                               FROM posts 
                               JOIN users ON posts.userID = users.userID 
                               WHERE threadID = :threadID 
                               ORDER BY created_at ASC");
        $stmt->execute(['threadID' => $threadID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($message, $userID, $threadID) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO posts (message, userID, threadID) 
                               VALUES (:message, :userID, :threadID)");
        $stmt->execute([
            'message' => $message,
            'userID' => $userID,
            'threadID' => $threadID
        ]);
    }
}
