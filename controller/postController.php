<?php
require_once("../config/config.php");
require_once("../model/Post.php");
global $pdo;

session_start();

$action = $_POST["action"] ?? "";

if ($action === "create") {
    $message = trim($_POST["message"]);
    $threadID = $_POST["threadID"];
    $userID = $_SESSION["user"]["userID"];

    if ($message && $threadID && $userID) {
        Post::create($message, $userID, $threadID);
        header("Location: ../view/thread.php?threadID=" . $threadID);
        exit();
    } else {
        die("Error al publicar el comentario.");
    }
}

if ($action === "delete") {
    $postID = $_GET["postID"];
    $threadID = $_GET["threadID"];
    $userID = $_SESSION["user"]["userID"];

    $stmt = $pdo->prepare("DELETE FROM posts WHERE postID = :postID AND userID = :userID");
    $stmt->execute([
        'postID' => $postID,
        'userID' => $userID
    ]);

    header("Location: ../view/thread.php?threadID=" . $threadID);
    exit();
}

if ($action === "update") {
    $postID = $_POST["postID"];
    $threadID = $_POST["threadID"];
    $message = trim($_POST["message"]);
    $userID = $_SESSION["user"]["userID"];

    $stmt = $pdo->prepare("UPDATE posts SET message = :message 
                           WHERE postID = :postID AND userID = :userID");
    $stmt->execute([
        'message' => $message,
        'postID' => $postID,
        'userID' => $userID
    ]);

    header("Location: ../view/thread.php?threadID=" . $threadID);
    exit();
}
