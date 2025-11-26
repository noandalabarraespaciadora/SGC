<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">✏️ Editar Nivel de Excelencia</h2>
        <p class="az-dashboard-text">Modifique los datos del nivel</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Mostrar errores de validación -->
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

        <form method="post" action="<?= base_url("niveles-excelencia/actualizar/{$nivel['id']}") ?>">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Abreviatura</label>
                <input type="text" class="form-control" name="abreviatura" 
                       value="<?= old('abreviatura', $nivel['abreviatura']) ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Nombre del Nivel</label>
                <input type="text" class="form-control" name="nivel" 
                       value="<?= old('nivel', $nivel['nivel']) ?>" required>
            </div>
            
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="<?= base_url('niveles-excelencia') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
<?php $this->endSection() ?>