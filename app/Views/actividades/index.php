<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📅 Gestión de Actividades</h2>
        <p class="az-dashboard-text">Administre las actividades del Consejo de la Magistratura</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Mensajes -->
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <a href="<?= base_url('actividades/nuevo') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva Actividad
                </a>
                <a href="<?= base_url('actividades/calendario') ?>" class="btn btn-outline-primary btn-sm">
                    <i class="fas fa-calendar me-1"></i> Vista Calendario
                </a>
                <a href="<?= base_url('actividades/lista') ?>" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-list me-1"></i> Vista Lista
                </a>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="get" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm"
                        placeholder="Buscar actividades..." value="<?= esc($search ?? '') ?>" style="width:250px;">
                    <button type="submit" class="btn btn-outline-primary btn-sm ms-2">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Sede</th>
                        <th>Modalidad</th>
                        <th>Tipo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($actividades)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No se encontraron actividades.
                                <br>
                                <a href="<?= base_url('actividades/nuevo') ?>" class="btn btn-primary btn-sm mt-2">
                                    <i class="fas fa-plus me-1"></i> Crear primera actividad
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($actividades as $index => $actividad): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= esc($actividad['titulo']) ?></strong>
                                    <?php if ($actividad['descripcion']): ?>
                                        <br>
                                        <small class="text-muted"><?= esc(substr($actividad['descripcion'], 0, 50)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $actividad['fecha'] ? date('d/m/Y', strtotime($actividad['fecha'])) : '<span class="text-muted">No definida</span>' ?>
                                </td>
                                <td>
                                    <?= $actividad['hora'] ? date('H:i', strtotime($actividad['hora'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td><?= esc($actividad['sede_nombre'] ?? '<span class="text-muted">No asignada</span>') ?></td>
                                <td><?= esc($actividad['modalidad_nombre'] ?? '<span class="text-muted">No asignada</span>') ?></td>
                                <td><?= esc($actividad['tipo_actividad_nombre'] ?? '<span class="text-muted">No asignado</span>') ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url("actividades/{$actividad['id']}") ?>"
                                            class="btn btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url("actividades/editar/{$actividad['id']}") ?>"
                                            class="btn btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" title="Eliminar"
                                            onclick="confirmarEliminar(<?= $actividad['id'] ?>, '<?= esc($actividad['titulo']) ?>')">
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

<!-- Formulario para eliminar -->
<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
    function confirmarEliminar(id, titulo) {
        if (confirm(`¿Está seguro de eliminar la actividad "${titulo}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('actividades/eliminar/') ?>${id}`;
            form.submit();
        }
    }
</script>
<?php $this->endSection() ?>