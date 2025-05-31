<?php
global $pdo;

session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /AA2/index.php");
    exit();
}

require_once("../config/config.php");
require_once("../model/Thread.php");
require_once("../model/Post.php");

$threadID = $_GET["threadID"] ?? null;
if (!$threadID) {
    die("Hilo no especificado.");
}

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Obtener datos del hilo
$stmt = $pdo->prepare("SELECT threads.*, users.username 
                       FROM threads 
                       JOIN users ON threads.userID = users.userID 
                       WHERE threadID = :threadID");
$stmt->execute(['threadID' => $threadID]);
$thread = $stmt->fetch(PDO::FETCH_ASSOC);

$posts = Post::getByThread($threadID);

include("header.php");
?>

<h2 class="mb-4"><?= htmlspecialchars($thread["name"]) ?></h2>

<div class="card bg-secondary text-light mb-4">
    <div class="card-body">
        <p class="mb-1"><?= nl2br(htmlspecialchars($thread["message"])) ?></p>
        <small>Por <?= htmlspecialchars($thread["username"]) ?> - <?= $thread["created_at"] ?></small>
    </div>
</div>

<h4>Comentarios</h4>

<?php if (empty($posts)): ?>
    <p class="text-muted">Aún no hay comentarios.</p>
<?php else: ?>
    <?php foreach ($posts as $post): ?>
        <div class="mb-3 border rounded p-3">
            <p><?= nl2br(htmlspecialchars($post["message"])) ?></p>
            <small>Por <?= htmlspecialchars($post["username"]) ?> | <?= $post["created_at"] ?></small>

            <?php if (isset($_SESSION["user"]) && $_SESSION["user"]["userID"] == $post["userID"]): ?>
                <div class="mt-2">
                    <a href="editPost.php?postID=<?= $post["postID"] ?>" class="btn btn-sm btn-outline-light">Editar</a>
                    <a href="../controller/PostController.php?action=delete&postID=<?= $post["postID"] ?>&threadID=<?= $threadID ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('¿Seguro que quieres eliminar este comentario?');">Eliminar</a>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<hr>

<h5>Responder</h5>

<form action="../controller/PostController.php" method="POST">
    <input type="hidden" name="action" value="create">
    <input type="hidden" name="threadID" value="<?= $threadID ?>">

    <div class="mb-3">
        <textarea name="message" rows="4" class="form-control bg-dark text-light" required></textarea>
    </div>

    <button type="submit" class="btn btn-success">Enviar</button>
</form>

<?php include("footer.php"); ?>
