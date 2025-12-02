<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle de Unificación</h2>
        <p class="az-dashboard-text">Información completa de la unificación</p>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="mb-4">
                    <h4><i class="fas fa-link text-primary me-2"></i> <?= esc($unificado['denominacion']) ?></h4>
                    <p class="text-muted">ID: #<?= $unificado['id'] ?></p>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong><i class="fas fa-calendar-plus me-2"></i>Fecha de creación:</strong><br>
                        <?= date('d/m/Y H:i', strtotime($unificado['created_at'])) ?>
                    </div>

                    <?php if ($unificado['updated_at'] && $unificado['updated_at'] != $unificado['created_at']): ?>
                        <div class="col-md-6 mb-3">
                            <strong><i class="fas fa-calendar-check me-2"></i>Última actualización:</strong><br>
                            <?= date('d/m/Y H:i', strtotime($unificado['updated_at'])) ?>
                        </div>
                    <?php endif; ?>
                </div>

                <hr>

                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Nota:</strong> Una unificación contiene varios concursos que se resuelven en conjunto cuando corresponden a la misma categoría de cargo.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sección de Concursos Asociados (Futura) -->
<div class="card shadow-sm mt-4">
    <div class="card-header">
        <h5 class="mb-0"><i class="fas fa-graduation-cap me-2"></i>Concursos Asociados</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-circle me-2"></i>
            Esta sección mostrará los concursos asociados a esta unificación cuando se implemente el módulo de Concursos.
        </div>
        <!-- Aquí se mostrarán los concursos cuando el módulo esté implementado -->
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("unificados/editar/{$unificado['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('unificados') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al Listado
    </a>
</div>
<?php $this->endSection() ?>