<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Estado de Concurso</h2>
        <p class="az-dashboard-text">Información completa del estado de concurso seleccionado</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <h5><strong>Estado de Concurso:</strong> <?= esc($estadoConcurso['denominacion']) ?></h5>
        <hr>
        <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($estadoConcurso['created_at'])) ?></p>
        <?php if ($estadoConcurso['updated_at'] && $estadoConcurso['updated_at'] != $estadoConcurso['created_at']): ?>
            <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($estadoConcurso['updated_at'])) ?></p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("estado-concursos/editar/{$estadoConcurso['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('estado-concursos') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>
<?php $this->endSection() ?>