<?php
require_once("../config/config.php");
require_once("../model/User.php");

session_start();
$action = $_POST["action"] ?? $_GET["action"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = $_POST["action"] ?? "";

    if ($action === "login") {
        $username = trim($_POST["username"]);
        $password = trim($_POST["password"]);

        $user = User::findByUsername($username);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user"] = $user;
            header("Location: /AA2/view/home.php");
            exit();
        } else {
            $_SESSION["login_error"] = "Usuario o contraseña incorrectos.";
            header("Location: /AA2/index.php");
            exit();
        }
    }
}

if ($action === "register") {
    $username = trim($_POST["username"]);
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password_raw = trim($_POST["password"]);

    // Validaciones
    if (empty($username) || strlen($username) < 3 || preg_match('/\s/', $username)) {
        $_SESSION["register_error"] = "El nombre de usuario debe tener al menos 3 caracteres y no contener espacios.";
        header("Location: ../view/register.php");
        exit();
    }

    if (empty($name)) {
        $_SESSION["register_error"] = "El nombre completo es obligatorio.";
        header("Location: ../view/register.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION["register_error"] = "Correo electrónico no válido.";
        header("Location: ../view/register.php");
        exit();
    }

    if (strlen($password_raw) < 6) {
        $_SESSION["register_error"] = "La contraseña debe tener al menos 6 caracteres.";
        header("Location: ../view/register.php");
        exit();
    }

    if (User::exists($username, $email)) {
        $_SESSION["register_error"] = "El nombre de usuario o el email ya están registrados.";
        header("Location: ../view/register.php");
        exit();
    }

    // Encriptar y registrar
    $password = password_hash($password_raw, PASSWORD_DEFAULT);
    User::create($username, $name, $email, $password);
    $_SESSION["user"] = User::findByUsername($username);

    $to = $email;
    $subject = "Bienvenido al foro Value Investing";
    $message = "Hola $username,\n\nGracias por registrarte en nuestro foro.\n¡Esperamos que disfrutes compartiendo ideas de inversión!";
    $headers = "From: foro@valueinvesting.local";

    mail($to, $subject, $message, $headers);
    file_put_contents("../logs/mail_log.txt", "EMAIL A: $to\nASUNTO: $subject\nMENSAJE:\n$message\n\n", FILE_APPEND);

    header("Location: /view/home.php");
    exit();
}

if ($action === "logout") {
    session_unset();
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/'); // ← esto elimina la cookie de sesión
    header("Location: /AA2/index.php");
    exit();
}




