<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Tipo de Actividad</h2>
        <p class="az-dashboard-text">Información completa del tipo de actividad seleccionado</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5><strong>Tipo de Actividad:</strong> <?= esc($tipoActividad['actividad']) ?></h5>
        <hr>
        <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($tipoActividad['created_at'])) ?></p>
        <?php if ($tipoActividad['updated_at'] && $tipoActividad['updated_at'] != $tipoActividad['created_at']): ?>
            <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($tipoActividad['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("tipo-actividades/editar/{$tipoActividad['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('tipo-actividades') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>