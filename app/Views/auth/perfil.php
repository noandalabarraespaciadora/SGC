<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content-body">
    <div class="row">
        <div class="col-12">
            <div class="az-dashboard-one-title">
                <div>
                    <h2 class="az-dashboard-title">👤 Mi Perfil</h2>
                    <p class="az-dashboard-text">Gestiona tu información personal</p>
                </div>
            </div>

            <!-- Mensajes flash -->
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

            <div class="row">
                <!-- Información Personal -->
                <div class="col-md-8">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">📝 Información Personal</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('perfil/actualizar') ?>" method="post">
                                <?= csrf_field() ?>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Apellido *</label>
                                            <input type="text" name="apellido" class="form-control" 
                                                   value="<?= old('apellido', $usuario['apellido']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Nombre *</label>
                                            <input type="text" name="nombre" class="form-control" 
                                                   value="<?= old('nombre', $usuario['nombre']) ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Alias *</label>
                                            <input type="text" name="alias" class="form-control" 
                                                   value="<?= old('alias', $usuario['alias']) ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>DNI</label>
                                            <input type="text" name="dni" class="form-control" 
                                                   value="<?= old('dni', $usuario['dni']) ?>" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email *</label>
                                    <input type="email" class="form-control" value="<?= $usuario['email'] ?>" readonly>
                                    <small class="text-muted">El email no puede ser modificado</small>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control" 
                                                   value="<?= old('fecha_nacimiento', $usuario['fecha_nacimiento']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Teléfono</label>
                                            <input type="text" name="telefono" class="form-control" 
                                                   value="<?= old('telefono', $usuario['telefono']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" class="form-control" 
                                           value="<?= old('direccion', $usuario['direccion']) ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Cargo Actual</label>
                                            <input type="text" name="cargo_actual" class="form-control" 
                                                   value="<?= old('cargo_actual', $usuario['cargo_actual']) ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Dependencia</label>
                                            <input type="text" name="dependencia" class="form-control" 
                                                   value="<?= old('dependencia', $usuario['dependencia']) ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Mensaje de Estado</label>
                                    <input type="text" name="mensaje_estado" class="form-control" 
                                           value="<?= old('mensaje_estado', $usuario['mensaje_estado']) ?>" 
                                           placeholder="Ej: En medio del incendio, trabajando...">
                                    <small class="text-muted">Mensaje breve que verán otros usuarios</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Estado</label>
                                    <select name="estado" class="form-control">
                                        <option value="Activo" <?= $usuario['estado'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                                        <option value="Ausente" <?= $usuario['estado'] == 'Ausente' ? 'selected' : '' ?>>Ausente</option>
                                        <option value="No Disponible" <?= $usuario['estado'] == 'No Disponible' ? 'selected' : '' ?>>No Disponible</option>
                                        <option value="Ocupado" <?= $usuario['estado'] == 'Ocupado' ? 'selected' : '' ?>>Ocupado</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-az-primary">Actualizar Perfil</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Cambiar Contraseña -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">🔒 Cambiar Contraseña</h6>
                        </div>
                        <div class="card-body">
                            <form action="<?= base_url('perfil/cambiar-password') ?>" method="post">
                                <?= csrf_field() ?>

                                <?php if (session()->getFlashdata('success_password')): ?>
                                    <div class="alert alert-success"><?= session()->getFlashdata('success_password') ?></div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('error_password')): ?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('error_password') ?></div>
                                <?php endif; ?>

                                <?php if (isset($errors_password) && $errors_password): ?>
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            <?php foreach ($errors_password as $e): ?>
                                                <li><?= $e ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group mb-3">
                                    <label>Contraseña Actual</label>
                                    <input type="password" name="password_actual" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Nueva Contraseña</label>
                                    <input type="password" name="nueva_password" class="form-control" required minlength="8">
                                </div>

                                <div class="form-group mb-3">
                                    <label>Confirmar Nueva Contraseña</label>
                                    <input type="password" name="confirmar_password" class="form-control" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
                            </form>
                        </div>
                    </div>

                    <!-- Información de la Cuenta -->
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h6 class="card-title mb-0">ℹ️ Información de la Cuenta</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Rol:</strong> <span class="badge bg-az-primary"><?= $usuario['rol'] ?></span></p>
                            <p><strong>Estado de Aprobación:</strong> 
                                <?php if ($usuario['aprobado']): ?>
                                    <span class="badge bg-success">Aprobado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Pendiente</span>
                                <?php endif; ?>
                            </p>
                            <p><strong>Miembro desde:</strong><br>
                                <?= date('d/m/Y', strtotime($usuario['created_at'])) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>