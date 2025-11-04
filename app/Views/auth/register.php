<?= $this->include('templates/header') ?>

<div class="auth-container">
    <h2 class="text-center mb-4">
        <i class="fas fa-user-plus"></i> Registrarse
    </h2>
    
    <!-- Mensajes de alerta -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle"></i> Errores de validación:
            <ul class="mb-0 mt-2">
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/procesar-registro') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre *</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" 
                           value="<?= old('nombre') ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido *</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" 
                           value="<?= old('apellido') ?>" required>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="alias" class="form-label">Alias *</label>
            <input type="text" class="form-control" id="alias" name="alias" 
                   value="<?= old('alias') ?>" required>
            <div class="form-text">Nombre de usuario único para el sistema</div>
        </div>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" class="form-control" id="email" name="email" 
                   value="<?= old('email') ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" name="telefono" 
                           value="<?= old('telefono') ?>">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <textarea class="form-control" id="direccion" name="direccion" 
                      rows="3"><?= old('direccion') ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña *</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text">Mínimo 8 caracteres</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Confirmar Contraseña *</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary w-100 btn-lg">
            <i class="fas fa-user-plus"></i> Registrarse
        </button>
    </form>
    
    <div class="text-center mt-3">
        <a href="<?= base_url('login') ?>">
            <i class="fas fa-sign-in-alt"></i> ¿Ya tienes cuenta? Inicia Sesión
        </a>
    </div>
</div>

<?= $this->include('templates/footer') ?>