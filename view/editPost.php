<?php
require_once("../config/config.php");
global $pdo;

session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

$postID = $_GET["postID"] ?? null;

if (!$postID) {
    die("ID del comentario no proporcionado.");
}

// Cargar el comentario de la base de datos
$stmt = $pdo->prepare("SELECT * FROM posts WHERE postID = :postID");
$stmt->execute(["postID" => $postID]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

// Validar autoría
if (!$post || $post["userID"] != $_SESSION["user"]["userID"]) {
    die("No tienes permisos para editar este comentario.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar comentario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">

<div class="container mt-5">
    <h2>Editar comentario</h2>

    <form method="POST" action="../controller/PostController.php">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="postID" value="<?= $post["postID"] ?>">
        <input type="hidden" name="threadID" value="<?= $post["threadID"] ?>">

        <div class="mb-3">
            <label for="message" class="form-label">Comentario</label>
            <textarea name="message" id="message" class="form-control" required><?= htmlspecialchars($post["message"]) ?></textarea>
        </div>

        <button type="submit" class="btn btn-light">Guardar cambios</button>
        <a href="thread.php?threadID=<?= $post["threadID"] ?>" class="btn btn-outline-light ms-2">Cancelar</a>
    </form>
</div>

</body>
</html>
