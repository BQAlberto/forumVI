<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: /AA2/index.php");
    exit();
}

require_once("../config/config.php");
require_once("../model/Topic.php");

$topics = Topic::getAll();

include("header.php");
?>

<h2 class="mb-4">Temas del Foro</h2>

<div class="row">
    <?php foreach ($topics as $topic): ?>
        <div class="col-md-6 mb-4">
            <div class="card bg-secondary text-light h-100">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($topic["name"]) ?></h5>
                    <a href="threads.php?topicID=<?= $topic['topicID'] ?>" class="btn btn-outline-light btn-sm">Ver hilos</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include("footer.php"); ?>
