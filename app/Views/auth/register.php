<?= view('partials/header_login') ?>

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
            <h2>Registro de Usuario</h2>
            <h5 class="text-muted">Completa tus datos para crear una cuenta.</h5>

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
            <form action="<?= base_url('auth/procesar-registro') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Apellido *</label>
                            <input type="text" name="apellido" class="form-control" value="<?= old('apellido') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nombre *</label>
                            <input type="text" name="nombre" class="form-control" value="<?= old('nombre') ?>" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Alias *</label>
                            <input type="text" name="alias" class="form-control" value="<?= old('alias') ?>" required>
                            <small class="text-muted">Nombre de usuario único</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>DNI</label>
                            <input type="text" name="dni" class="form-control" value="<?= old('dni') ?>" maxlength="10">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Fecha de Nacimiento</label>
                            <input type="date" name="fecha_nacimiento" class="form-control" value="<?= old('fecha_nacimiento') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Teléfono</label>
                            <input type="text" name="telefono" class="form-control" value="<?= old('telefono') ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <input type="text" name="direccion" class="form-control" value="<?= old('direccion') ?>">
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Cargo Actual</label>
                            <input type="text" name="cargo_actual" class="form-control" value="<?= old('cargo_actual') ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Dependencia</label>
                            <input type="text" name="dependencia" class="form-control" value="<?= old('dependencia') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contraseña *</label>
                            <input type="password" name="password" class="form-control" required minlength="8">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Confirmar Contraseña *</label>
                            <input type="password" name="confirm_password" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" required id="terminos">
                        <label class="form-check-label" for="terminos">
                            Acepto los términos y condiciones
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn btn-az-primary btn-block">Registrarse</button>
            </form>
        </div><!-- az-signup-header -->

        <div class="az-signup-footer">
            <br>
            <p>¿Ya tienes una cuenta? <a href="<?= base_url('login') ?>">Inicia sesión aquí</a></p>
        </div>
    </div><!-- az-column-signup -->
</div><!-- az-signup-wrapper -->

<?= view('partials/footer_login') ?>