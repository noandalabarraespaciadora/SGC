<?php
$data['navbar'] = true;
?>
<?= $this->include('templates/header', $data) ?>

<!-- Mensajes de alerta -->
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
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h4 class="mb-0">
                    <i class="fas fa-users-cog"></i> Administrar Usuarios
                </h4>
            </div>
            <div class="card-body">
                <?php if (empty($usuarios)): ?>
                    <div class="alert alert-info text-center">
                        <i class="fas fa-info-circle"></i> No hay usuarios registrados en el sistema.
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre Completo</th>
                                    <th>Alias</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Nivel</th>
                                    <th>Estado</th>
                                    <th>Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td>#<?= $usuario['id'] ?></td>
                                    <td>
                                        <strong><?= $usuario['nombre'] ?> <?= $usuario['apellido'] ?></strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-secondary"><?= $usuario['alias'] ?></span>
                                    </td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <?= $usuario['telefono'] ?: 
                                            '<span class="text-muted">No especificado</span>' ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $usuario['nivel'] === 'sistema' ? 'warning' : 'info' ?>">
                                            <?= ucfirst($usuario['nivel']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-<?= $usuario['activo'] ? 'success' : 'danger' ?>">
                                            <?= $usuario['activo'] ? 'Activo' : 'Inactivo' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <small><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <!-- Cambiar Estado -->
                                            <a href="<?= base_url('dashboard/usuario/cambiar-estado/' . $usuario['id']) ?>" 
                                               class="btn btn-<?= $usuario['activo'] ? 'warning' : 'success' ?>"
                                               title="<?= $usuario['activo'] ? 'Desactivar' : 'Activar' ?>">
                                                <i class="fas fa-<?= $usuario['activo'] ? 'times' : 'check' ?>"></i>
                                            </a>
                                            
                                            <!-- Cambiar Nivel -->
                                            <a href="<?= base_url('dashboard/usuario/cambiar-nivel/' . $usuario['id']) ?>" 
                                               class="btn btn-<?= $usuario['nivel'] === 'sistema' ? 'info' : 'warning' ?>"
                                               title="Cambiar a <?= $usuario['nivel'] === 'sistema' ? 'Usuario' : 'Sistema' ?>">
                                                <i class="fas fa-user-<?= $usuario['nivel'] === 'sistema' ? 'shield' : 'cog' ?>"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-info-circle"></i> Información de Niveles:</h6>
                                <ul class="mb-0">
                                    <li><strong>Usuario:</strong> Acceso básico al sistema</li>
                                    <li><strong>Sistema:</strong> Permisos de administración completos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-start mt-3">
                    <a href="<?= base_url('/dashboard') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>