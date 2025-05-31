<?php
require_once("../config/config.php");
require_once("../model/Thread.php");
global $pdo;

session_start();

$action = $_POST["action"] ?? $_GET["action"] ?? "";

if ($action === "create") {
    $name = trim($_POST["name"]);
    $message = trim($_POST["message"]);
    $topicID = $_POST["topicID"];
    $userID = $_SESSION["user"]["userID"];

    if ($name && $message && $topicID) {
        Thread::create($name, $message, $userID, $topicID);
        header("Location: ../view/threads.php?topicID=" . $topicID);
        exit();
    } else {
        die("Faltan datos para crear el hilo.");
    }
}
    if ($action === "delete") {
        $threadID = $_GET["threadID"];
        $userID = $_SESSION["user"]["userID"];

        $stmt = $pdo->prepare("DELETE FROM threads WHERE threadID = :threadID AND userID = :userID");
        $stmt->execute(['threadID' => $threadID, 'userID' => $userID]);

        header("Location: ../view/home.php"); // o threads.php si lo prefieres
        exit();
    }

    if ($action === "update") {
        $threadID = $_POST["threadID"];
        $name = trim($_POST["name"]);
        $message = trim($_POST["message"]);
        $userID = $_SESSION["user"]["userID"];

        $stmt = $pdo->prepare("UPDATE threads SET name = :name, message = :message 
                           WHERE threadID = :threadID AND userID = :userID");
        $stmt->execute([
            'name' => $name,
            'message' => $message,
            'threadID' => $threadID,
            'userID' => $userID
        ]);

        header("Location: ../view/threads.php?topicID=" . $_POST["topicID"]);
        exit();

}
