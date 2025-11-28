<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">✏️ Editar Tipo de Actividad</h2>
        <p class="az-dashboard-text">Modifique los datos del tipo de actividad</p>
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

        <form method="post" action="<?= base_url("tipo-actividades/actualizar/{$tipoActividad['id']}") ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Tipo de Actividad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="actividad"
                    value="<?= old('actividad', $tipoActividad['actividad']) ?>" required maxlength="255">
                <div class="form-text">Máximo 255 caracteres. Debe ser único en el sistema.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Color <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="color" class="form-control form-control-color" name="color"
                        value="<?= old('color', $tipoActividad['color'] ?? '#007bff') ?>" title="Seleccione un color" required>
                    <input type="text" class="form-control" name="color_text"
                        value="<?= old('color', $tipoActividad['color'] ?? '#007bff') ?>" maxlength="7"
                        placeholder="#007bff" pattern="^#[0-9A-Fa-f]{6}$" required>
                </div>
                <div class="form-text">Seleccione un color para identificar este tipo de actividad.</div>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="<?= base_url('tipo-actividades') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.querySelector('input[name="color"]');
        const colorText = document.querySelector('input[name="color_text"]');

        // Sincronizar color picker con texto
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });

        // Sincronizar texto con color picker (con validación)
        colorText.addEventListener('input', function() {
            if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
                colorPicker.value = this.value;
            }
        });
    });
</script>
<?php $this->endSection() ?>