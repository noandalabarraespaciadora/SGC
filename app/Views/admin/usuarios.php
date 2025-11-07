<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content-body">
    <div class="row">
        <div class="col-12">
            <div class="az-dashboard-one-title">
                <div>
                    <h2 class="az-dashboard-title">👥 Administración de Usuarios</h2>
                    <p class="az-dashboard-text">Gestiona todos los usuarios del sistema</p>
                </div>
                <div>
                    <a href="<?= base_url('admin/usuarios/crear') ?>" class="btn btn-az-primary">
                        <i class="fas fa-plus"></i> Crear Usuario
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
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Apellido y Nombre</th>
                                    <th>Alias</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Aprobado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                <tr>
                                    <td><?= $usuario['id'] ?></td>
                                    <td>
                                        <strong><?= $usuario['apellido'] ?>, <?= $usuario['nombre'] ?></strong>
                                        <?php if ($usuario['mensaje_estado']): ?>
                                            <br><small class="text-muted">"<?= $usuario['mensaje_estado'] ?>"</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $usuario['alias'] ?></td>
                                    <td><?= $usuario['email'] ?></td>
                                    <td>
                                        <span class="badge 
                                            <?= $usuario['rol'] == 'Sistemas' ? 'bg-danger' : 
                                               ($usuario['rol'] == 'Experto' ? 'bg-warning' : 'bg-primary') ?>">
                                            <?= $usuario['rol'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge 
                                            <?= $usuario['estado'] == 'Activo' ? 'bg-success' : 
                                               ($usuario['estado'] == 'Ausente' ? 'bg-warning' : 
                                               ($usuario['estado'] == 'Ocupado' ? 'bg-info' : 'bg-secondary')) ?>">
                                            <?= $usuario['estado'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($usuario['aprobado']): ?>
                                            <span class="badge bg-success">✓ Aprobado</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">✗ No Aprobado</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('admin/usuarios/editar/' . $usuario['id']) ?>" 
                                               class="btn btn-outline-primary" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <a href="<?= base_url('admin/usuarios/cambiar-aprobacion/' . $usuario['id']) ?>" 
                                               class="btn btn-outline-<?= $usuario['aprobado'] ? 'warning' : 'success' ?>" 
                                               title="<?= $usuario['aprobado'] ? 'Desaprobar' : 'Aprobar' ?>">
                                                <i class="fas fa-<?= $usuario['aprobado'] ? 'times' : 'check' ?>"></i>
                                            </a>
                                            
                                            <a href="<?= base_url('admin/usuarios/resetear-password/' . $usuario['id']) ?>" 
                                               class="btn btn-outline-info" title="Resetear Contraseña"
                                               onclick="return confirm('¿Estás seguro de resetear la contraseña?')">
                                                <i class="fas fa-key"></i>
                                            </a>

                                            <!-- Estados rápidos -->
                                            <div class="btn-group btn-group-sm">
                                                <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                                        data-bs-toggle="dropdown" title="Cambiar Estado">
                                                    <i class="fas fa-user-clock"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="<?= base_url('admin/usuarios/cambiar-estado/' . $usuario['id'] . '/Activo') ?>">Activo</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('admin/usuarios/cambiar-estado/' . $usuario['id'] . '/Ausente') ?>">Ausente</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('admin/usuarios/cambiar-estado/' . $usuario['id'] . '/No Disponible') ?>">No Disponible</a></li>
                                                    <li><a class="dropdown-item" href="<?= base_url('admin/usuarios/cambiar-estado/' . $usuario['id'] . '/Ocupado') ?>">Ocupado</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>