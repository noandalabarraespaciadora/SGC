<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📋 Lista de Actividades</h2>
        <p class="az-dashboard-text">Vista detallada de todas las actividades con filtros avanzados</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Filtros -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="get" id="filtrosForm">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Tipo de Actividad</label>
                            <select class="form-control" name="tipo" id="filtroTipo">
                                <option value="">Todos los tipos</option>
                                <?php foreach ($tiposActividad as $tipo): ?>
                                    <option value="<?= $tipo['id'] ?>" <?= ($filtros['tipo'] == $tipo['id']) ? 'selected' : '' ?>>
                                        <?= esc($tipo['actividad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sede</label>
                            <select class="form-control" name="sede" id="filtroSede">
                                <option value="">Todas las sedes</option>
                                <?php foreach ($sedes as $sede): ?>
                                    <option value="<?= $sede['id'] ?>" <?= ($filtros['sede'] == $sede['id']) ? 'selected' : '' ?>>
                                        <?= esc($sede['denominacion']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Modalidad</label>
                            <select class="form-control" name="modalidad" id="filtroModalidad">
                                <option value="">Todas las modalidades</option>
                                <?php foreach ($modalidades as $modalidad): ?>
                                    <option value="<?= $modalidad['id'] ?>" <?= ($filtros['modalidad'] == $modalidad['id']) ? 'selected' : '' ?>>
                                        <?= esc($modalidad['modalidad']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Búsqueda</label>
                            <input type="text" class="form-control" name="search" placeholder="Buscar..." value="<?= esc($search ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Desde</label>
                            <input type="date" class="form-control" name="fecha_desde" value="<?= $filtros['fecha_desde'] ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fecha Hasta</label>
                            <input type="date" class="form-control" name="fecha_hasta" value="<?= $filtros['fecha_hasta'] ?>">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-search me-1"></i> Aplicar Filtros
                            </button>
                            <a href="<?= base_url('actividades/lista') ?>" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Limpiar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de actividades -->
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Título</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Duración</th>
                        <th>Sede</th>
                        <th>Modalidad</th>
                        <th>Tipo</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($actividades)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="fas fa-search fa-2x text-muted mb-2"></i>
                                <p>No se encontraron actividades con los filtros aplicados.</p>
                                <a href="<?= base_url('actividades/nuevo') ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Crear nueva actividad
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($actividades as $index => $actividad): ?>
                            <tr>
                                <td><strong>#<?= $actividad['id'] ?></strong></td>
                                <td>
                                    <strong><?= esc($actividad['titulo']) ?></strong>
                                    <?php if ($actividad['descripcion']): ?>
                                        <br>
                                        <small class="text-muted"><?= esc(substr($actividad['descripcion'], 0, 80)) ?>...</small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $actividad['fecha'] ? date('d/m/Y', strtotime($actividad['fecha'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <?= $actividad['hora'] ? date('H:i', strtotime($actividad['hora'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <?= $actividad['duracion'] ? "{$actividad['duracion']} min" : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <?= esc($actividad['sede_nombre'] ?? '<span class="text-muted">-</span>') ?>
                                </td>
                                <td>
                                    <?= esc($actividad['modalidad_nombre'] ?? '<span class="text-muted">-</span>') ?>
                                </td>
                                <td>
                                    <span class="badge badge-tipo-<?= $actividad['id_tipo_actividad'] ?? '1' ?>">
                                        <?= esc($actividad['tipo_actividad_nombre'] ?? 'Sin tipo') ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
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

<!-- Botones de acción -->
<div class="mt-3 d-flex justify-content-between">
    <a href="<?= base_url('actividades') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado principal
    </a>
    <div class="d-flex gap-2">
        <a href="<?= base_url('actividades/calendario') ?>" class="btn btn-outline-primary">
            <i class="fas fa-calendar me-1"></i> Vista Calendario
        </a>
        <a href="<?= base_url('actividades/nuevo') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Nueva Actividad
        </a>
        <button class="btn btn-outline-secondary" onclick="window.print()">
            <i class="fas fa-print me-1"></i> Imprimir
        </button>
    </div>
</div>

<!-- Formulario para eliminar -->
<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<style>
    .badge-tipo-1 {
        background: #1976d2;
    }

    .badge-tipo-2 {
        background: #7b1fa2;
    }

    .badge-tipo-3 {
        background: #388e3c;
    }

    .badge-tipo-4 {
        background: #f57c00;
    }

    .badge-tipo-5 {
        background: #c2185b;
    }

    .badge-tipo-6 {
        background: #0277bd;
    }

    .badge-tipo-7 {
        background: #7b1fa2;
    }

    .badge-tipo-8 {
        background: #388e3c;
    }
</style>

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