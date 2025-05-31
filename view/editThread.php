<?php
session_start();
require_once("../config/config.php");
global $pdo;

$threadID = $_GET["threadID"] ?? null;

if (!$threadID) {
    die("Hilo no especificado.");
}

$stmt = $pdo->prepare("SELECT * FROM threads WHERE threadID = :threadID");
$stmt->execute(['threadID' => $threadID]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$thread || $_SESSION["user"]["userID"] != $thread["userID"]) {
    die("No tienes permiso para editar este hilo.");
}

include("header.php");
?>

<h2>Editar hilo</h2>

<form method="POST" action="../controller/ThreadController.php">
    <input type="hidden" name="action" value="update">
    <input type="hidden" name="threadID" value="<?= $thread["threadID"] ?>">
    <input type="hidden" name="topicID" value="<?= $thread["topicID"] ?>">

    <div class="mb-3">
        <label>Título</label>
        <input type="text" name="name" class="form-control bg-dark text-light" value="<?= htmlspecialchars($thread["name"]) ?>" required>
    </div>

    <div class="mb-3">
        <label>Mensaje</label>
        <textarea name="message" class="form-control bg-dark text-light" required><?= htmlspecialchars($thread["message"]) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>

<?php include("footer.php"); ?>
