<div class="row justify-content-center">
    <div class="col-md-6">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>

        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger">
                <?= $_SESSION['login_error']; unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="controller/UserController.php">
            <input type="hidden" name="action" value="login">

            <div class="mb-3">
                <label for="username" class="form-label">Nombre de usuario</label>
                <input type="text" class="form-control bg-dark text-light border-secondary" id="username" name="username" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control bg-dark text-light border-secondary" id="password" name="password" required>
            </div>

            <button type="submit" class="form-control bg-dark text-light border-secondary w-100">Entrar</button>
        </form>

        <div class="text-center mt-3">
            <p>Solicitud de registro<a href="view/register.php" class="btn btn-link">Registro</a></p>
        </div>
    </div>
</div>
