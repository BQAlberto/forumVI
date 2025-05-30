<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Foro Value Investing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background-color: #2b2f32;" class="text-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="/index.php">Foro Value Investing</a>

        <?php if (isset($_SESSION["user"])): ?>
            <div class="d-flex text-white ms-auto">
                <span class="me-3">Bienvenido, <?= htmlspecialchars($_SESSION["user"]["username"]) ?></span>
                <a href="/AA2/controller/UserController.php?action=logout" class="btn btn-outline-light btn-sm">Cerrar sesión</a>
            </div>
        <?php endif; ?>
    </div>
</nav>

<div class="container mt-5">
