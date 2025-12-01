<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Libro</h2>
        <p class="az-dashboard-text">Información completa del libro seleccionado</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <?php if ($libro['url_foto']): ?>
                    <img src="<?= base_url($libro['url_foto']) ?>" alt="Portada" class="img-fluid rounded" style="max-height: 300px;">
                <?php else: ?>
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 300px;">
                        <i class="fas fa-book text-muted fa-5x"></i>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h4><?= esc($libro['titulo']) ?></h4>
                <p class="text-muted">por <?= esc($libro['autor'] ?? 'Autor no especificado') ?></p>

                <div class="mb-3">
                    <strong>Editorial:</strong> <?= esc($libro['editorial'] ?? 'No especificada') ?>
                </div>

                <div class="mb-3">
                    <strong>ISBN:</strong> <?= esc($libro['n_isbn'] ?? 'No disponible') ?>
                </div>

                <div class="mb-3">
                    <strong>Número de Inventario:</strong> <?= esc($libro['n_inventario']) ?>
                </div>

                <?php if ($libro['ubicacion']): ?>
                    <div class="mb-3">
                        <strong>Ubicación:</strong> <?= esc($libro['ubicacion']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($libro['descripcion']): ?>
                    <div class="mb-3">
                        <strong>Descripción:</strong><br>
                        <?= nl2br(esc($libro['descripcion'])) ?>
                    </div>
                <?php endif; ?>

                <hr>
                <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($libro['created_at'])) ?></p>
                <?php if ($libro['updated_at'] && $libro['updated_at'] != $libro['created_at']): ?>
                    <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($libro['updated_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("biblioteca/editar/{$libro['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('biblioteca') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>