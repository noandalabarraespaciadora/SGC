<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content-body">
    <div class="row">
        <div class="col-12">
            <div class="az-dashboard-one-title">
                <div>
                    <h2 class="az-dashboard-title">
                        <?= $usuario ? '✏️ Editar Usuario' : '👤 Crear Usuario' ?>
                    </h2>
                    <p class="az-dashboard-text">
                        <?= $usuario ? 'Modifica la información del usuario' : 'Agrega un nuevo usuario al sistema' ?>
                    </p>
                </div>
                <div>
                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Volver a Usuarios
                    </a>
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

            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="<?= $usuario ? base_url('admin/usuarios/guardar/' . $usuario['id']) : base_url('admin/usuarios/guardar') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="row">
                            <!-- Información Básica -->
                            <div class="col-md-6">
                                <h5 class="mb-3 border-bottom pb-2">📋 Información Básica</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Apellido *</label>
                                            <input type="text" name="apellido" class="form-control" 
                                                   value="<?= old('apellido', $usuario['apellido'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Nombre *</label>
                                            <input type="text" name="nombre" class="form-control" 
                                                   value="<?= old('nombre', $usuario['nombre'] ?? '') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Alias *</label>
                                            <input type="text" name="alias" class="form-control" 
                                                   value="<?= old('alias', $usuario['alias'] ?? '') ?>" required>
                                            <small class="text-muted">Nombre de usuario único</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>DNI</label>
                                            <input type="text" name="dni" class="form-control" 
                                                   value="<?= old('dni', $usuario['dni'] ?? '') ?>" maxlength="10">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Email *</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?= old('email', $usuario['email'] ?? '') ?>" required
                                           <?= $usuario ? 'readonly' : '' ?>>
                                    <?php if ($usuario): ?>
                                        <small class="text-muted">El email no puede ser modificado</small>
                                    <?php endif; ?>
                                </div>

                                <?php if (!$usuario): ?>
                                    <div class="form-group mb-3">
                                        <label>Contraseña *</label>
                                        <input type="password" name="password" class="form-control" required minlength="8">
                                        <small class="text-muted">Mínimo 8 caracteres</small>
                                    </div>
                                <?php else: ?>
                                    <div class="form-group mb-3">
                                        <label>Cambiar Contraseña</label>
                                        <input type="password" name="password" class="form-control" 
                                               placeholder="Dejar vacío para mantener la actual">
                                        <small class="text-muted">Completar solo si desea cambiar la contraseña</small>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Información Adicional -->
                            <div class="col-md-6">
                                <h5 class="mb-3 border-bottom pb-2">📝 Información Adicional</h5>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Fecha de Nacimiento</label>
                                            <input type="date" name="fecha_nacimiento" class="form-control" 
                                                   value="<?= old('fecha_nacimiento', $usuario['fecha_nacimiento'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Teléfono</label>
                                            <input type="text" name="telefono" class="form-control" 
                                                   value="<?= old('telefono', $usuario['telefono'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Dirección</label>
                                    <input type="text" name="direccion" class="form-control" 
                                           value="<?= old('direccion', $usuario['direccion'] ?? '') ?>">
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Cargo Actual</label>
                                            <input type="text" name="cargo_actual" class="form-control" 
                                                   value="<?= old('cargo_actual', $usuario['cargo_actual'] ?? '') ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label>Dependencia</label>
                                            <input type="text" name="dependencia" class="form-control" 
                                                   value="<?= old('dependencia', $usuario['dependencia'] ?? '') ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Mensaje de Estado</label>
                                    <input type="text" name="mensaje_estado" class="form-control" 
                                           value="<?= old('mensaje_estado', $usuario['mensaje_estado'] ?? '') ?>" 
                                           placeholder="Ej: En medio del incendio, trabajando...">
                                    <small class="text-muted">Mensaje breve que verán otros usuarios</small>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Configuración del Sistema -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Rol *</label>
                                    <select name="rol" class="form-control" required>
                                        <option value="Usuario" <?= (old('rol', $usuario['rol'] ?? '') == 'Usuario') ? 'selected' : '' ?>>Usuario</option>
                                        <option value="Experto" <?= (old('rol', $usuario['rol'] ?? '') == 'Experto') ? 'selected' : '' ?>>Experto</option>
                                        <option value="Sistemas" <?= (old('rol', $usuario['rol'] ?? '') == 'Sistemas') ? 'selected' : '' ?>>Sistemas</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Estado *</label>
                                    <select name="estado" class="form-control" required>
                                        <option value="Activo" <?= (old('estado', $usuario['estado'] ?? '') == 'Activo') ? 'selected' : '' ?>>Activo</option>
                                        <option value="Ausente" <?= (old('estado', $usuario['estado'] ?? '') == 'Ausente') ? 'selected' : '' ?>>Ausente</option>
                                        <option value="No Disponible" <?= (old('estado', $usuario['estado'] ?? '') == 'No Disponible') ? 'selected' : '' ?>>No Disponible</option>
                                        <option value="Ocupado" <?= (old('estado', $usuario['estado'] ?? '') == 'Ocupado') ? 'selected' : '' ?>>Ocupado</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label>Aprobación</label>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" name="aprobado" value="1" 
                                               id="aprobado" <?= (old('aprobado', $usuario['aprobado'] ?? 1) ? 'checked' : '') ?>>
                                        <label class="form-check-label" for="aprobado">
                                            Cuenta Aprobada
                                        </label>
                                    </div>
                                    <small class="text-muted">Usuarios no aprobados no pueden iniciar sesión</small>
                                </div>
                            </div>
                        </div>

                        <!-- Mostrar errores de validación -->
                        <?php if (isset($errors) && $errors): ?>
                            <div class="alert alert-danger">
                                <strong>Errores de validación:</strong>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Información adicional para usuarios existentes -->
                        <?php if ($usuario): ?>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6>📊 Información del Sistema</h6>
                                            <p class="mb-1"><strong>ID:</strong> <?= $usuario['id'] ?></p>
                                            <p class="mb-1"><strong>Creado:</strong> <?= date('d/m/Y H:i', strtotime($usuario['created_at'])) ?></p>
                                            <p class="mb-0"><strong>Modificado:</strong> <?= date('d/m/Y H:i', strtotime($usuario['updated_at'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6>🔧 Acciones Rápidas</h6>
                                            <div class="d-grid gap-2">
                                                <a href="<?= base_url('admin/usuarios/resetear-password/' . $usuario['id']) ?>" 
                                                   class="btn btn-outline-warning btn-sm"
                                                   onclick="return confirm('¿Estás seguro de resetear la contraseña? Se generará una nueva contraseña temporal.')">
                                                    <i class="fas fa-key"></i> Resetear Contraseña
                                                </a>
                                                <a href="<?= base_url('admin/usuarios/cambiar-aprobacion/' . $usuario['id']) ?>" 
                                                   class="btn btn-outline-<?= $usuario['aprobado'] ? 'warning' : 'success' ?> btn-sm">
                                                    <i class="fas fa-<?= $usuario['aprobado'] ? 'times' : 'check' ?>"></i> 
                                                    <?= $usuario['aprobado'] ? 'Desaprobar' : 'Aprobar' ?> Usuario
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Botones de acción -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= base_url('admin/usuarios') ?>" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-az-primary">
                                        <i class="fas fa-save"></i> 
                                        <?= $usuario ? 'Actualizar Usuario' : 'Crear Usuario' ?>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>