<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">✏️ Editar Docente</h2>
        <p class="az-dashboard-text">Modifique los datos del docente</p>
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

        <form method="post" action="<?= base_url("docentes/actualizar/{$docente['id']}") ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Apellido y Nombre <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="apellido_y_nombre"
                        value="<?= old('apellido_y_nombre', $docente['apellido_y_nombre']) ?>" required maxlength="255">
                    <div class="form-text">Máximo 255 caracteres. Debe ser único en el sistema.</div>
                </div>
            </div>

            <div class="mb-3">
                <label for="docenteDireccion" class="form-label">Dirección</label>
                <textarea class="form-control" name="direccion" rows="2"><?= old('direccion', $docente['direccion']) ?></textarea>
                <div class="form-text">Máximo 500 caracteres.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Teléfonos</label>
                <div id="telefonosContainer">
                    <?php if (!empty($docente['telefonos'])): ?>
                        <?php foreach ($docente['telefonos'] as $telefono): ?>
                            <div class="input-group mb-2">
                                <input type="tel" class="form-control" name="telefonos[]"
                                    value="<?= esc($telefono['numero']) ?>" placeholder="Número de teléfono">
                                <button type="button" class="btn btn-outline-danger" onclick="removerTelefono(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="input-group mb-2">
                            <input type="tel" class="form-control" name="telefonos[]" placeholder="Número de teléfono">
                            <button type="button" class="btn btn-outline-danger" onclick="removerTelefono(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarTelefono()">
                    <i class="fas fa-plus me-1"></i> Agregar Teléfono
                </button>
                <div class="form-text">Puede editar, eliminar o agregar nuevos teléfonos.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Emails</label>
                <div id="emailsContainer">
                    <?php if (!empty($docente['emails'])): ?>
                        <?php foreach ($docente['emails'] as $email): ?>
                            <div class="input-group mb-2">
                                <input type="email" class="form-control" name="emails[]"
                                    value="<?= esc($email['direccion']) ?>" placeholder="Dirección de email">
                                <button type="button" class="btn btn-outline-danger" onclick="removerEmail(this)">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="input-group mb-2">
                            <input type="email" class="form-control" name="emails[]" placeholder="Dirección de email">
                            <button type="button" class="btn btn-outline-danger" onclick="removerEmail(this)">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarEmail()">
                    <i class="fas fa-plus me-1"></i> Agregar Email
                </button>
                <div class="form-text">Puede editar, eliminar o agregar nuevos emails.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Actual</label>
                <?php if ($docente['url_foto']): ?>
                    <div class="mb-2">
                        <img src="<?= base_url($docente['url_foto']) ?>" alt="Foto actual" class="img-thumbnail" style="max-height: 100px;">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="eliminarFoto" name="eliminar_foto">
                            <label class="form-check-label" for="eliminarFoto">Eliminar foto actual</label>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No hay foto registrada</p>
                <?php endif; ?>

                <label for="docenteFoto" class="form-label">Nueva Foto</label>
                <input type="file" class="form-control" name="url_foto" accept="image/*">
                <div class="form-text">Formatos: JPG, PNG, GIF. Máx. 2MB</div>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="<?= base_url('docentes') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>

<script>
    function agregarTelefono() {
        $('#telefonosContainer').append(`
        <div class="input-group mb-2">
            <input type="tel" class="form-control" name="telefonos[]" placeholder="Número de teléfono">
            <button type="button" class="btn btn-outline-danger" onclick="removerTelefono(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `);
    }

    function removerTelefono(button) {
        $(button).closest('.input-group').remove();
    }

    function agregarEmail() {
        $('#emailsContainer').append(`
        <div class="input-group mb-2">
            <input type="email" class="form-control" name="emails[]" placeholder="Dirección de email">
            <button type="button" class="btn btn-outline-danger" onclick="removerEmail(this)">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `);
    }

    function removerEmail(button) {
        $(button).closest('.input-group').remove();
    }
</script>
<?php $this->endSection() ?>