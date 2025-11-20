<?= view('partials/header_login') ?>

<div class="az-signup-wrapper">
    <!-- Columna izquierda (logo + título) -->
    <div class="az-column-signup-left">
        <div class="az-signup-header">
            <!-- <i class="typcn typcn-location-arrow-outline"></i> -->
        <div class="logo-container mb-0">
            <img src="<?= base_url('assets/images/logo.gif') ?>" alt="Logo SGC" class="logo-gif" style="width: 100px; height: auto;">
        </div>
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
        <div class="az-signup-header" style="width: 100%; max-width: 400px;">
            <h2>Inicio de Sesión</h2>
            <h5 class="text-muted">Ingresa tus credenciales para continuar.</h5>

            <!-- Mensajes flash / errores -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
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

                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" 
                           placeholder="tu@email.com" required>
                </div>
                
                <div class="form-group mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" 
                           placeholder="Ingresa tu contraseña" required>
                </div>

                <div class="form-group mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="remember">
                        <label class="form-check-label" for="remember">
                            Recordar sesión
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-az-primary btn-block w-100 mb-3">Ingresar</button>
                
                <div class="text-center">
                    <a href="<?= base_url('recuperar-password') ?>" class="text-muted">
                        <i class="fas fa-key"></i> ¿Olvidaste tu contraseña?
                    </a>
                </div>
            </form>
        </div><!-- az-signup-header -->

        <div class="az-signup-footer mt-4">
            <p>¿No tenes una cuenta de usuario? <a href="<?= base_url('register') ?>">Click acá</a> para registrarte</p>
        </div>
    </div><!-- az-column-signup -->
</div><!-- az-signup-wrapper -->

<?= view('partials/footer_login') ?>