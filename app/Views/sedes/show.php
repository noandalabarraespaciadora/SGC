<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle de la Sede</h2>
        <p class="az-dashboard-text">Información completa de la sede seleccionada</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5><strong>Denominación:</strong> <?= esc($sede['denominacion']) ?></h5>
        <hr>
        <p><strong>Dirección:</strong> <?= esc($sede['direccion'] ?? 'No especificada') ?></p>
        <p><strong>Email:</strong> <?= esc($sede['email'] ?? 'No especificado') ?></p>
        <p><strong>Teléfono:</strong> <?= esc($sede['telefono'] ?? 'No especificado') ?></p>
        <hr>
        <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($sede['created_at'])) ?></p>
        <?php if ($sede['updated_at'] && $sede['updated_at'] != $sede['created_at']): ?>
            <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($sede['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("sedes/editar/{$sede['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('sedes') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>