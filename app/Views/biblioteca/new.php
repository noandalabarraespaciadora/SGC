<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">➕ Nuevo Libro</h2>
        <p class="az-dashboard-text">Complete el formulario para agregar un nuevo libro a la biblioteca</p>
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

        <form method="post" action="<?= base_url('biblioteca/crear') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="titulo"
                            value="<?= old('titulo') ?>"
                            placeholder="Ej: Derecho Constitucional Argentino" required maxlength="255">
                        <div class="form-text">Máximo 255 caracteres. Debe ser único en el sistema.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Autor</label>
                        <input type="text" class="form-control" name="autor"
                            value="<?= old('autor') ?>"
                            placeholder="Ej: Luis Roberto Barroso" maxlength="255">
                        <div class="form-text">Máximo 255 caracteres.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Editorial</label>
                        <input type="text" class="form-control" name="editorial"
                            value="<?= old('editorial') ?>"
                            placeholder="Ej: Editorial Jurídica" maxlength="255">
                        <div class="form-text">Máximo 255 caracteres.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">ISBN</label>
                            <input type="text" class="form-control" name="n_isbn"
                                value="<?= old('n_isbn') ?>"
                                placeholder="Ej: 978-950-123-456-7" maxlength="20">
                            <div class="form-text">Máximo 20 caracteres.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Número de Inventario <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="n_inventario"
                                value="<?= old('n_inventario') ?>"
                                placeholder="Ej: LIB-001" required maxlength="50">
                            <div class="form-text">Máximo 50 caracteres. Debe ser único.</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ubicación</label>
                        <input type="text" class="form-control" name="ubicacion"
                            value="<?= old('ubicacion') ?>"
                            placeholder="Ej: Estante A, Sección Derecho" maxlength="255">
                        <div class="form-text">Máximo 255 caracteres.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" rows="3"
                            placeholder="Breve descripción del contenido del libro..."><?= old('descripcion') ?></textarea>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Portada</label>
                        <div class="border rounded p-3 text-center">
                            <img id="previewPortada" src="" alt="Vista previa" class="img-fluid mb-2 d-none" style="max-height: 200px;">
                            <input type="file" class="form-control" name="url_foto" id="libroPortada" accept="image/*" onchange="previewImage(this)">
                            <small class="text-muted">Formatos: JPG, PNG, GIF. Máx. 2MB</small>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar Libro
            </button>
            <a href="<?= base_url('biblioteca') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>

<script>
    function previewImage(input) {
        const preview = document.getElementById('previewPortada');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('d-none');
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
</script>
<?php $this->endSection() ?>