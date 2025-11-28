<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">✏️ Editar Actividad</h2>
        <p class="az-dashboard-text">Modifique los datos de la actividad</p>
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

        <form method="post" action="<?= base_url("actividades/actualizar/{$actividad['id']}") ?>">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label class="form-label">Título de la Actividad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="titulo"
                    value="<?= old('titulo', $actividad['titulo']) ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="date" class="form-control" name="fecha"
                        value="<?= old('fecha', $actividad['fecha']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Hora</label>
                    <input type="time" class="form-control" name="hora"
                        value="<?= old('hora', $actividad['hora']) ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Duración (minutos)</label>
                <input type="number" class="form-control" name="duracion"
                    value="<?= old('duracion', $actividad['duracion']) ?>" min="1">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de Actividad</label>
                    <select class="form-control" name="id_tipo_actividad">
                        <option value="">Seleccione tipo</option>
                        <?php foreach ($tiposActividad as $tipo): ?>
                            <option value="<?= $tipo['id'] ?>"
                                <?= old('id_tipo_actividad', $actividad['id_tipo_actividad']) == $tipo['id'] ? 'selected' : '' ?>>
                                <?= esc($tipo['actividad']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Sede</label>
                    <select class="form-control" name="id_sede">
                        <option value="">Seleccione sede</option>
                        <?php foreach ($sedes as $sede): ?>
                            <option value="<?= $sede['id'] ?>"
                                <?= old('id_sede', $actividad['id_sede']) == $sede['id'] ? 'selected' : '' ?>>
                                <?= esc($sede['denominacion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Modalidad</label>
                    <select class="form-control" name="id_modalidad">
                        <option value="">Seleccione modalidad</option>
                        <?php foreach ($modalidades as $modalidad): ?>
                            <option value="<?= $modalidad['id'] ?>"
                                <?= old('id_modalidad', $actividad['id_modalidad']) == $modalidad['id'] ? 'selected' : '' ?>>
                                <?= esc($modalidad['modalidad']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="4"><?= old('descripcion', $actividad['descripcion']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="<?= base_url('actividades') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>
<?php $this->endSection() ?>