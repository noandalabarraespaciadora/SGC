<?php
// File: app/Views/rotacion/personal/index.php

$this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">👥 Gestión de Personal</h2>
                    <p class="az-dashboard-text">Administre el personal disponible para rotaciones</p>
                </div>
                <div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalNuevoPersonal">
                        <i class="fas fa-plus me-1"></i> Nuevo Personal
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

            <!-- Listado -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="50">ID</th>
                            <th>Personal</th>
                            <th>Categoría</th>
                            <th>Área</th>
                            <th>Estado</th>
                            <th width="150">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($personal)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <h4>No hay personal registrado</h4>
                                        <p class="text-muted">Agregue personal para comenzar a asignar rotaciones</p>
                                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoPersonal">
                                            <i class="fas fa-plus me-1"></i> Agregar Personal
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($personal as $persona): ?>
                                <?php
                                $avatarColor = get_avatar_color($persona['nombre'] . ' ' . $persona['apellido']);
                                $iniciales = strtoupper(substr($persona['nombre'], 0, 1) . substr($persona['apellido'], 0, 1));
                                ?>
                                <tr>
                                    <td>#<?= $persona['id'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <?php if ($persona['url_foto']): ?>
                                                <img src="<?= base_url($persona['url_foto']) ?>" alt="Foto"
                                                    class="rounded-circle me-3" width="40" height="40">
                                            <?php else: ?>
                                                <div class="rounded-circle me-3 d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px; background-color: <?= $avatarColor ?>; color: white;">
                                                    <?= $iniciales ?>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <div class="fw-bold"><?= $persona['nombre'] ?> <?= $persona['apellido'] ?></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge <?= $persona['categoria'] === 'jerarquico' ? 'bg-primary' : 'bg-secondary' ?>">
                                            <?= $persona['categoria'] === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico' ?>
                                        </span>
                                    </td>
                                    <td><?= $persona['area'] ?: '<span class="text-muted">Sin área</span>' ?></td>
                                    <td>
                                        <span class="badge <?= $persona['activo'] ? 'bg-success' : 'bg-danger' ?>">
                                            <?= $persona['activo'] ? 'Activo' : 'Inactivo' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-warning"
                                                onclick="editarPersonal(<?= $persona['id'] ?>)"
                                                title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-outline-danger"
                                                onclick="eliminarPersonal(<?= $persona['id'] ?>, '<?= $persona['nombre'] ?> <?= $persona['apellido'] ?>')"
                                                title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo/Editar Personal -->
<div class="modal fade" id="modalNuevoPersonal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuevo Personal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('rotacion/personal/guardar') ?>" method="post" enctype="multipart/form-data" id="formPersonal">
                <?= csrf_field() ?>
                <input type="hidden" name="id" id="personalId">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nombre" id="personalNombre" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apellido" id="personalApellido" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Categoría <span class="text-danger">*</span></label>
                            <select class="form-control" name="categoria" id="personalCategoria" required>
                                <option value="">Seleccionar...</option>
                                <option value="jerarquico">Jerárquico</option>
                                <option value="no_jerarquico">No Jerárquico</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Área</label>
                            <input type="text" class="form-control" name="area" id="personalArea" placeholder="Ej: Administración">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto</label>
                        <input type="file" class="form-control" name="url_foto" id="personalFoto" accept="image/*">
                        <div class="form-text">Tamaño máximo: 2MB. Formatos: JPG, PNG, GIF</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="activo" id="personalActivo" value="1" checked>
                            <label class="form-check-label" for="personalActivo">
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

<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<style>
    .empty-state {
        text-align: center;
        padding: 3rem;
    }

    .empty-state i {
        opacity: 0.5;
    }
</style>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    function editarPersonal(id) {
        // Aquí cargaríamos los datos del personal vía AJAX
        // Por ahora, mostramos un alert
        alert('Funcionalidad de edición en desarrollo');
    }

    function eliminarPersonal(id, nombre) {
        if (confirm(`¿Está seguro de eliminar a "${nombre}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('rotacion/personal/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Limpiar formulario al abrir modal
        $('#modalNuevoPersonal').on('show.bs.modal', function() {
            $('#formPersonal')[0].reset();
            $('#personalId').val('');
            $('.modal-title').text('Nuevo Personal');
        });
    });
</script>
<?php $this->endSection(); ?>