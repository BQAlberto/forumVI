<?php
class Thread {
    public static function getByTopic($topicID) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT threads.*, users.username 
                               FROM threads 
                               JOIN users ON threads.userID = users.userID 
                               WHERE topicID = :topicID 
                               ORDER BY created_at DESC");
        $stmt->execute(['topicID' => $topicID]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function create($name, $message, $userID, $topicID) {
        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO threads (name, message, userID, topicID) 
                           VALUES (:name, :message, :userID, :topicID)");
        $stmt->execute([
            'name' => $name,
            'message' => $message,
            'userID' => $userID,
            'topicID' => $topicID
        ]);
    }

}
