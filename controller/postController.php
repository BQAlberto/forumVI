<?php
require_once("../config/config.php");
require_once("../model/Post.php");
global $pdo;

session_start();

$action = $_POST["action"] ?? $_GET["action"] ?? "";

if ($action === "create") {
    $message = trim($_POST["message"]);
    $threadID = $_POST["threadID"];
    $userID = $_SESSION["user"]["userID"];

    if ($message && $threadID) {
        Post::create($message, $userID, $threadID);
        $_SESSION["mensaje"] = "Comentario creado correctamente.";
        $_SESSION["tipo"] = "success";
        header("Location: ../view/thread.php?threadID=" . $threadID);
        exit();
    } else {
        $_SESSION["mensaje"] = "Error: Faltan datos.";
        $_SESSION["tipo"] = "danger";
        header("Location: ../view/thread.php?threadID=" . $threadID);
        exit();
    }
}

if ($action === "delete") {
    global $pdo;
    $postID = $_POST["postID"] ?? $_GET["postID"] ?? null;
    $threadID = $_POST["threadID"] ?? $_GET["threadID"] ?? null;
    $userID = $_SESSION["user"]["userID"];

    if ($postID && $threadID) {
        $stmt = $pdo->prepare("DELETE FROM posts WHERE postID = :postID AND userID = :userID");
        $stmt->execute([
            'postID' => $postID,
            'userID' => $userID
        ]);

        $_SESSION["mensaje"] = "Comentario eliminado correctamente.";
        $_SESSION["tipo"] = "warning";
    } else {
        $_SESSION["mensaje"] = "No se pudo eliminar el comentario.";
        $_SESSION["tipo"] = "danger";
    }

    header("Location: ../view/thread.php?threadID=" . $threadID);
    exit();
}

if ($action === "update") {
    $postID = $_POST["postID"];
    $message = trim($_POST["message"]);
    $threadID = $_POST["threadID"];
    $userID = $_SESSION["user"]["userID"];

    if ($message && $postID && $threadID) {
        $stmt = $pdo->prepare("UPDATE posts SET message = :message WHERE postID = :postID AND userID = :userID");
        $stmt->execute([
            'message' => $message,
            'postID' => $postID,
            'userID' => $userID
        ]);
        $_SESSION["mensaje"] = "Comentario editado con éxito.";
        $_SESSION["tipo"] = "success";
    } else {
        $_SESSION["mensaje"] = "No se pudo editar el comentario.";
        $_SESSION["tipo"] = "danger";
    }

    header("Location: ../view/thread.php?threadID=" . $threadID);
    exit();
}

