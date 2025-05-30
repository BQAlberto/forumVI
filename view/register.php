<?php
include("header.php");
?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Registro de Usuario</h2>

        <?php if (isset($_SESSION["register_error"])): ?>
            <div class="alert alert-danger"><?= $_SESSION["register_error"]; unset($_SESSION["register_error"]); ?></div>
        <?php endif; ?>

        <form method="POST" action="../controller/UserController.php">
            <input type="hidden" name="action" value="register">

            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Nombre completo</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrarse</button>
        </form>

        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-link">¿Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</div>

<?php include("footer.php"); ?>
