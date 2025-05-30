<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si el usuario ya ha iniciado sesión, redirige a la home
if (isset($_SESSION['user'])) {
    header("Location: view/home.php");
    exit();
}

include("view/header.php");
include("view/login.php");
include("view/footer.php");
