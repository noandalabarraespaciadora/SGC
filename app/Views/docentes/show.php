<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Docente</h2>
        <p class="az-dashboard-text">Información completa del docente seleccionado</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <?php if ($docente['url_foto']): ?>
                    <img src="<?= base_url($docente['url_foto']) ?>" alt="Foto" class="img-fluid rounded-circle mb-3" style="max-height: 200px;">
                <?php else: ?>
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                        <i class="fas fa-user-graduate text-white fa-4x"></i>
                    </div>
                <?php endif; ?>
                <h4><?= esc($docente['apellido_y_nombre']) ?></h4>
                <p class="text-muted">ID: #<?= $docente['id'] ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="mb-3">Información de Contacto</h5>
                <div class="mb-3">
                    <strong>Dirección:</strong><br>
                    <?= esc($docente['direccion'] ?? 'No especificada') ?>
                </div>

                <div class="mb-3">
                    <strong>Teléfonos:</strong><br>
                    <?php if (!empty($docente['telefonos'])): ?>
                        <?php foreach ($docente['telefonos'] as $telefono): ?>
                            <span class="badge bg-primary me-1 mb-1"><?= esc($telefono['numero']) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">Sin teléfonos registrados</span>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <strong>Emails:</strong><br>
                    <?php if (!empty($docente['emails'])): ?>
                        <?php foreach ($docente['emails'] as $email): ?>
                            <span class="badge bg-success me-1 mb-1"><?= esc($email['direccion']) ?></span>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span class="text-muted">Sin emails registrados</span>
                    <?php endif; ?>
                </div>

                <hr>
                <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($docente['created_at'])) ?></p>
                <?php if ($docente['updated_at'] && $docente['updated_at'] != $docente['created_at']): ?>
                    <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($docente['updated_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("docentes/editar/{$docente['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('docentes') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<!-- Sección de Concursos (Futura) -->
<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h5 class="mb-0">Historial de Concursos</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Esta sección mostrará los concursos en los que ha participado el docente cuando se implemente el módulo de Concursos.
        </div>
        <!-- Aquí se mostrarán los concursos cuando el módulo esté implementado -->
    </div>
</div>
<?php $this->endSection() ?>