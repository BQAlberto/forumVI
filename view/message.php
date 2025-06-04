<?php if (isset($_SESSION["mensaje"])): ?>
    <div class="container mt-3">
        <div class="alert alert-<?= $_SESSION["tipo"] ?? 'info' ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION["mensaje"]) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    </div>
    <?php
    unset($_SESSION["mensaje"]);
    unset($_SESSION["tipo"]);
    ?>
<?php endif; ?>
