<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /AA2/index.php");
    exit();
}

require_once("../config/config.php");
require_once("../model/Thread.php");

$topicID = $_GET["topicID"] ?? null;

if (!$topicID) {
    die("Tema no especificado.");
}

$threads = Thread::getByTopic($topicID);

include("header.php");
?>

<h2 class="mb-4">Hilos del tema <?= htmlspecialchars($topicID) ?></h2>
<a href="newThread.php?topicID=<?= $topicID ?>" class="btn btn-success mb-4">Crear nuevo hilo</a>

<?php if (empty($threads)): ?>
    <p class="text-muted">No hay hilos en este tema todavía.</p>
<?php else: ?>
    <div class="list-group">
        <?php foreach ($threads as $thread): ?>
            <div class="list-group-item bg-secondary text-light mb-2">
                <h5 class="mb-1">
                    <a href="thread.php?threadID=<?= $thread["threadID"] ?>" class="text-decoration-none text-light">
                        <?= htmlspecialchars($thread["name"]) ?>
                    </a>
                </h5>
                <p class="mb-1"><?= nl2br(htmlspecialchars($thread["message"])) ?></p>
                <small>Por <?= htmlspecialchars($thread["username"]) ?> - <?= $thread["created_at"] ?></small>
            </div>
            <?php if ($_SESSION["user"]["userID"] == $thread["userID"]): ?>
                <div class="mt-2">
                    <a href="editThread.php?threadID=<?= $thread["threadID"] ?>" class="btn btn-sm btn-outline-light">Editar</a>
                    <a href="../controller/ThreadController.php?action=delete&threadID=<?= $thread["threadID"] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar este hilo?');">Eliminar</a>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include("footer.php"); ?>
