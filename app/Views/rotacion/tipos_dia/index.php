<?php
// File: app/Views/rotacion/tipos_dia/index.php

$this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">📅 Tipos de Día</h2>
                    <p class="az-dashboard-text">Administre los tipos de día para rotaciones</p>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoTipo">
                        <i class="fas fa-plus me-1"></i> Nuevo Tipo
                    </button>
                </div>
            </div>

            <!-- Alertas -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Listado -->
            <div class="row" id="tiposDiaList">
                <?php foreach ($tipos_dia as $tipo): ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0"><?= $tipo['nombre'] ?></h5>
                                    <span class="badge" style="background-color: <?= $tipo['color'] ?>; color: <?= get_contrast_color($tipo['color']) ?>">
                                        ●
                                    </span>
                                </div>

                                <?php if ($tipo['descripcion']): ?>
                                    <p class="card-text small text-muted"><?= $tipo['descripcion'] ?></p>
                                <?php endif; ?>

                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <div>
                                        <?php if ($tipo['requiere_acuerdo']): ?>
                                            <span class="badge bg-info">Requiere Acuerdo</span>
                                        <?php endif; ?>
                                        <span class="badge <?= $tipo['activo'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $tipo['activo'] ? 'Activo' : 'Inactivo' ?>
                                        </span>
                                    </div>
                                    <div class="btn-group btn-group-sm">
                                        <button class="btn btn-outline-warning"
                                            onclick="editarTipo(<?= $tipo['id'] ?>)"
                                            title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-danger"
                                            onclick="eliminarTipo(<?= $tipo['id'] ?>, '<?= $tipo['nombre'] ?>')"
                                            title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo/Editar Tipo -->
<div class="modal fade" id="modalNuevoTipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Tipo de Día</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('rotacion/tipos-dia/guardar') ?>" method="post" id="formTipo">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="tipoId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nombre" id="tipoNombre" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Color <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" name="color" id="tipoColor"
                                value="#007bff" title="Seleccionar color">
                            <input type="text" class="form-control" id="tipoColorHex" value="#007bff"
                                pattern="^#[0-9A-Fa-f]{6}$" maxlength="7">
                        </div>
                        <div class="form-text">Seleccione un color o ingrese el código hexadecimal</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="tipoDescripcion" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="requiere_acuerdo" id="tipoRequiereAcuerdo" value="1">
                            <label class="form-check-label" for="tipoRequiereAcuerdo">
                                Requiere número de acuerdo
                            </label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo" id="tipoActivo" value="1" checked>
                            <label class="form-check-label" for="tipoActivo">
                                Activo
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="deleteTipoForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    const tiposDia = <?= json_encode($tipos_dia) ?>;

    // Sincronizar inputs de color
    $('#tipoColor').on('input', function() {
        $('#tipoColorHex').val(this.value);
    });

    $('#tipoColorHex').on('input', function() {
        if (this.value.match(/^#[0-9A-Fa-f]{6}$/)) {
            $('#tipoColor').val(this.value);
        }
    });

    function editarTipo(id) {
        const tipo = tiposDia.find(t => t.id == id);

        if (tipo) {
            $('#tipoId').val(tipo.id);
            $('#tipoNombre').val(tipo.nombre);
            $('#tipoColor').val(tipo.color);
            $('#tipoColorHex').val(tipo.color);
            $('#tipoDescripcion').val(tipo.descripcion || '');
            $('#tipoRequiereAcuerdo').prop('checked', tipo.requiere_acuerdo == 1);
            $('#tipoActivo').prop('checked', tipo.activo == 1);

            $('.modal-title').text('Editar Tipo de Día');

            // Abrir modal
            const modal = new bootstrap.Modal(document.getElementById('modalNuevoTipo'));
            modal.show();
        }
    }

    function eliminarTipo(id, nombre) {
        if (confirm(`¿Está seguro de eliminar el tipo "${nombre}"?`)) {
            const form = document.getElementById('deleteTipoForm');
            form.action = `<?= base_url('rotacion/tipos-dia/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Limpiar formulario al cerrar modal
        $('#modalNuevoTipo').on('hidden.bs.modal', function() {
            $('#formTipo')[0].reset();
            $('#tipoId').val('');
            $('#tipoColor').val('#007bff');
            $('#tipoColorHex').val('#007bff');
            $('.modal-title').text('Nuevo Tipo de Día');
        });
    });
</script>
<?php $this->endSection(); ?>