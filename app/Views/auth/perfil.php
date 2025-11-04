<?php
$data['navbar'] = true;
?>
<?= $this->include('templates/header', $data) ?>

<!-- Mensajes de alerta generales -->
<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show mt-3">
        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show mt-3">
        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<div class="row mt-4">
    <div class="col-md-12">
        <!-- Información del Usuario -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle"></i> Información de Mi Perfil
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Nombre Completo:</th>
                                <td><?= $usuario['nombre'] ?> <?= $usuario['apellido'] ?></td>
                            </tr>
                            <tr>
                                <th>Alias:</th>
                                <td><span class="badge bg-secondary"><?= $usuario['alias'] ?></span></td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td><?= $usuario['email'] ?></td>
                            </tr>
                            <tr>
                                <th>Teléfono:</th>
                                <td><?= $usuario['telefono'] ?: '<span class="text-muted">No especificado</span>' ?></td>
                            </tr>
                            <tr>
                                <th>Nivel:</th>
                                <td>
                                    <span class="badge bg-<?= $usuario['nivel'] === 'sistema' ? 'warning' : 'info' ?>">
                                        <?= ucfirst($usuario['nivel']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Estado:</th>
                                <td>
                                    <span class="badge bg-<?= $usuario['activo'] ? 'success' : 'danger' ?>">
                                        <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                            </div>
                            <h5><?= $usuario['nombre'] ?> <?= $usuario['apellido'] ?></h5>
                            <p class="text-muted"><?= $usuario['alias'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Editar Información Básica -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">
                    <i class="fas fa-user-edit"></i> Editar Información Personal
                </h5>
            </div>
            <div class="card-body">
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

                <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre *</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" 
                                       value="<?= old('nombre', $usuario['nombre'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido *</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" 
                                       value="<?= old('apellido', $usuario['apellido'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alias" class="form-label">Alias *</label>
                        <input type="text" class="form-control" id="alias" name="alias" 
                               value="<?= old('alias', $usuario['alias'] ?? '') ?>" required>
                        <div class="form-text">Nombre de usuario único para el sistema</div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="<?= $usuario['email'] ?? '' ?>" readonly>
                        <div class="form-text">El email no se puede modificar</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" 
                                       value="<?= old('telefono', $usuario['telefono'] ?? '') ?>">
                                <div class="form-text">Ej: +34 123 456 789</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nivel de Usuario</label>
                                <input type="text" class="form-control" 
                                       value="<?= ucfirst($usuario['nivel'] ?? '') ?>" readonly>
                                <div class="form-text">Contacta al administrador para cambiar el nivel</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea class="form-control" id="direccion" name="direccion" 
                                  rows="3" placeholder="Ingresa tu dirección completa"><?= old('direccion', $usuario['direccion'] ?? '') ?></textarea>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Actualizar Información
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Cambiar Contraseña -->
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="fas fa-key"></i> Cambiar Contraseña
                </h5>
            </div>
            <div class="card-body">
                <!-- Mensajes específicos para cambio de contraseña -->
                <?php if (session()->getFlashdata('success_password')): ?>
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success_password') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error_password')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error_password') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('errors_password')): ?>
                    <div class="alert alert-danger alert-dismissible fade show">
                        <i class="fas fa-exclamation-triangle"></i> Errores en el cambio de contraseña:
                        <ul class="mb-0 mt-2">
                            <?php foreach (session()->getFlashdata('errors_password') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('perfil/cambiar-password') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="password_actual" class="form-label">Contraseña Actual *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_actual" name="password_actual" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordActual">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Ingresa tu contraseña actual</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="nueva_password" class="form-label">Nueva Contraseña *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="nueva_password" name="nueva_password" required minlength="8">
                                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordNueva">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Mínimo 8 caracteres</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="confirmar_password" class="form-label">Confirmar Nueva Contraseña *</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                                    <button type="button" class="btn btn-outline-secondary" id="togglePasswordConfirmar">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="form-text">Repite la nueva contraseña</div>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning btn-lg">
                            <i class="fas fa-sync-alt"></i> Cambiar Contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información Adicional -->
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle"></i> Información de la Cuenta
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th><i class="fas fa-calendar-plus"></i> Fecha de Registro:</th>
                                <td><?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-check"></i> Última Actualización:</th>
                                <td><?= date('d/m/Y H:i', strtotime($usuario['updated_at'])) ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th><i class="fas fa-id-card"></i> ID de Usuario:</th>
                                <td>#<?= $usuario['id'] ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-database"></i> Registro en BD:</th>
                                <td><?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón Volver -->
        <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-4">
            <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
            </a>
        </div>
    </div>
</div>

<script>
// Mostrar/ocultar contraseñas
document.addEventListener('DOMContentLoaded', function() {
    // Función para toggle de visibilidad de contraseña
    const togglePassword = (inputId, buttonId) => {
        const input = document.getElementById(inputId);
        const button = document.getElementById(buttonId);
        
        if (input && button) {
            button.addEventListener('click', function() {
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                const icon = this.querySelector('i');
                icon.classList.toggle('fa-eye');
                icon.classList.toggle('fa-eye-slash');
            });
        }
    };

    // Aplicar a los tres campos de contraseña
    togglePassword('password_actual', 'togglePasswordActual');
    togglePassword('nueva_password', 'togglePasswordNueva');
    togglePassword('confirmar_password', 'togglePasswordConfirmar');

    // Validación en tiempo real de coincidencia de contraseñas
    const confirmarInput = document.getElementById('confirmar_password');
    const nuevaInput = document.getElementById('nueva_password');
    
    if (confirmarInput && nuevaInput) {
        confirmarInput.addEventListener('input', function() {
            const nuevaPassword = nuevaInput.value;
            const confirmarPassword = this.value;
            
            if (confirmarPassword && nuevaPassword !== confirmarPassword) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
            } else if (confirmarPassword) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
            } else {
                this.classList.remove('is-invalid', 'is-valid');
            }
        });

        // También validar cuando se escribe en nueva contraseña
        nuevaInput.addEventListener('input', function() {
            const confirmarPassword = confirmarInput.value;
            if (confirmarPassword) {
                confirmarInput.dispatchEvent(new Event('input'));
            }
        });
    }

    // Prevenir doble envío de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            }
        });
    });
});
</script>

<?= $this->include('templates/footer') ?>