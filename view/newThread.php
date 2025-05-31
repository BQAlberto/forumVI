<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /AA2/index.php");
    exit();
}

$topicID = $_GET["topicID"] ?? null;
if (!$topicID) {
    die("Tema no especificado.");
}

include("header.php");
?>

<h2 class="mb-4">Nuevo hilo en el tema <?= htmlspecialchars($topicID) ?></h2>

<form action="../controller/ThreadController.php" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="hidden" name="topicID" value="<?= $topicID ?>">

    <div class="mb-3">
        <label class="form-label">Título del hilo</label>
        <input type="text" name="name" class="form-control bg-dark text-light" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Mensaje inicial</label>
        <textarea name="message" rows="5" class="form-control bg-dark text-light" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Publicar hilo</button>
</form>

<?php include("footer.php"); ?>

