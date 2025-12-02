<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">➕ Nueva Unificación</h2>
        <p class="az-dashboard-text">Complete el formulario para crear una nueva unificación de concursos</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('unificados/crear') ?>">
            <?= csrf_field() ?>

            <div class="mb-4">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    Una unificación agrupa varios concursos que se resuelven en conjunto cuando corresponden a la misma categoría de cargo.
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Denominación <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="denominacion"
                        value="<?= old('denominacion') ?>"
                        placeholder="Ej: Unificación de concursos de Profesor Titular - Área Informática"
                        required maxlength="255">
                    <div class="form-text">Máximo 255 caracteres. Debe ser única en el sistema.</div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Unificación
                </button>
                <a href="<?= base_url('unificados') ?>" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection() ?>