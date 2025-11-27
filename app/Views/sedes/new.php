<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">➕ Nueva Sede</h2>
        <p class="az-dashboard-text">Complete el formulario para crear una nueva sede</p>
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

        <form method="post" action="<?= base_url('sedes/crear') ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Denominación <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="denominacion" 
                       value="<?= old('denominacion') ?>" 
                       placeholder="Ej: Sede Saenz Peña" required maxlength="255">
                <div class="form-text">Máximo 255 caracteres. Debe ser única en el sistema.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" 
                       value="<?= old('direccion') ?>" 
                       placeholder="Ej: Calle Principal 123" maxlength="500">
                <div class="form-text">Máximo 500 caracteres.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" 
                       value="<?= old('email') ?>" 
                       placeholder="Ej: sede@consejo.gov.ar" maxlength="100">
                <div class="form-text">Máximo 100 caracteres. Formato de email válido.</div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono" 
                       value="<?= old('telefono') ?>" 
                       placeholder="Ej: +54 364 442-1234" maxlength="50">
                <div class="form-text">Máximo 50 caracteres.</div>
            </div>
            
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar
            </button>
            <a href="<?= base_url('sedes') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
<?php $this->endSection() ?>