<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Nivel de Excelencia</h2>
        <p class="az-dashboard-text">Información completa del nivel seleccionado</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5><strong>Abreviatura:</strong> <?= esc($nivel['abreviatura']) ?></h5>
        <h6><strong>Nombre:</strong> <?= esc($nivel['nivel']) ?></h6>
        <hr>
        <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($nivel['created_at'])) ?></p>
        <?php if ($nivel['updated_at']): ?>
            <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($nivel['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("niveles-excelencia/editar/{$nivel['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('niveles-excelencia') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>