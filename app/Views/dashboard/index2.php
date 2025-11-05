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
        <div class="user-info">
            <div class="row">
                <div class="col-md-8">
                    <h3><i class="fas fa-user-shield"></i> Bienvenido al Sistema</h3>
                    <h4><?= $usuario_nombre ?> <?= $usuario_apellido ?></h4>
                    <p class="mb-0">
                        <strong>Alias:</strong> <?= $usuario_alias ?> | 
                        <strong>Nivel:</strong> 
                        <span class="badge bg-<?= $usuario_nivel === 'sistema' ? 'warning' : 'info' ?>">
                            <?= ucfirst($usuario_nivel) ?>
                        </span>
                    </p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="fas fa-shield-alt fa-5x opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Tarjeta de Estadísticas -->
    <div class="col-md-4">
        <div class="card stats-card bg-primary text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5>Usuarios Totales</h5>
                        <h2><?= $total_usuarios ?></h2>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-users fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stats-card bg-success text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5>Mi Nivel</h5>
                        <h2><?= ucfirst($usuario_nivel) ?></h2>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-user-tag fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card stats-card bg-info text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5>Mi Alias</h5>
                        <h4><?= $usuario_alias ?></h4>
                    </div>
                    <div class="col-4 text-end">
                        <i class="fas fa-at fa-3x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-info-circle"></i> Información de tu Cuenta</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th>Nombre Completo:</th>
                        <td><?= $usuario_nombre ?> <?= $usuario_apellido ?></td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><?= $usuario_email ?></td>
                    </tr>
                    <tr>
                        <th>Alias:</th>
                        <td><?= $usuario_alias ?></td>
                    </tr>
                    <tr>
                        <th>Nivel:</th>
                        <td>
                            <span class="badge bg-<?= $usuario_nivel === 'sistema' ? 'warning' : 'info' ?>">
                                <?= ucfirst($usuario_nivel) ?>
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-rocket"></i> Acciones Rápidas</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="<?= base_url('/perfil') ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-user-edit"></i> Editar Mi Perfil
                    </a>
                    <?php if ($usuario_nivel === 'sistema'): ?>
                    <a href="<?= base_url('/dashboard/usuarios') ?>" class="btn btn-outline-warning btn-lg">
                        <i class="fas fa-users-cog"></i> Administrar Usuarios
                    </a>
                    <?php endif; ?>
                    <a href="<?= base_url('/logout') ?>" class="btn btn-outline-danger btn-lg">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->include('templates/footer') ?>