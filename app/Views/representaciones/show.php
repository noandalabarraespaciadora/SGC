<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle de la Representación</h2>
        <p class="az-dashboard-text">Información completa de la representación seleccionada</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5><strong>Representación:</strong> <?= esc($representacion['representacion']) ?></h5>
        <hr>
        <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($representacion['created_at'])) ?></p>
        <?php if ($representacion['updated_at'] && $representacion['updated_at'] != $representacion['created_at']): ?>
            <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($representacion['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("representaciones/editar/{$representacion['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('representaciones') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>