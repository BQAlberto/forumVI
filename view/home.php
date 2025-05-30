<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../index.php");
    exit();
}
include("header.php");
?>

<h2>Bienvenido al foro de Value Investing</h2>

<?php include("footer.php"); ?>

