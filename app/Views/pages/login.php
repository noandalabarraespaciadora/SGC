<?= view('partials/head_login') ?>

<div class="az-signup-wrapper">
    <!-- Columna izquierda (logo + título) -->
    <div class="az-column-signup-left">
        <div class="az-signup-header">
            <i class="typcn typcn-location-arrow-outline"></i>
            <h1>SGC<span></span></h1>
            <h2>Sistema de Gestión de Concursos</h2>
            <h5 class="text-muted">
                Dirección General de Tecnología<br>
                Consejo de la Magistratura y Jurado de Enjuiciamiento<br>
                Provincia del Chaco
            </h5>
        </div>
    </div><!-- az-column-signup-left -->

    <!-- Columna derecha (formulario) -->
    <div class="az-column-signup d-flex flex-column justify-content-center align-items-center">
        <div class="az-signup-header">
            <h2>Inicio de Sesión</h2>
            <h5 class="text-muted">Ingresa tus credenciales para continuar.</h5>

            <!-- Mensajes flash / errores -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <?php if (isset($errors) && $errors): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= $e ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="<?= base_url('auth/procesar-login') ?>" method="post">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-az-primary btn-block">Ingresar</button>
            </form>
        </div><!-- az-signup-header -->

        <div class="az-signup-footer">
            <br>
            <p>¿No tenes una cuenta de usuario? <a href="<?= base_url('register') ?>">Click acá</a> para registrarte</p>
        </div>
    </div><!-- az-column-signup -->
</div><!-- az-signup-wrapper -->

<?= view('partials/foot_login') ?>