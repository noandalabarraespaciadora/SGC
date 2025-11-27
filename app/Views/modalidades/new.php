<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">➕ Nueva Modalidad</h2>
        <p class="az-dashboard-text">Complete el formulario para crear una nueva modalidad</p>
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

        <form method="post" action="<?= base_url('modalidades/crear') ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Modalidad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="modalidad" 
                       value="<?= old('modalidad') ?>" 
                       placeholder="Ej: Presencial" required maxlength="255">
                <div class="form-text">Máximo 255 caracteres. Debe ser única en el sistema.</div>
            </div>
            
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="<?= base_url('modalidades') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
<?php $this->endSection() ?>