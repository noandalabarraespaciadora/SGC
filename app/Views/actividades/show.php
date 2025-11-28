<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle de la Actividad</h2>
        <p class="az-dashboard-text">Información completa de la actividad seleccionada</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-4">
            <h4><?= esc($actividad['titulo']) ?></h4>
            <span class="badge badge-tipo-<?= $actividad['id_tipo_actividad'] ?? '1' ?>">
                <?= esc($actividad['tipo_actividad']['actividad'] ?? 'Sin tipo') ?>
            </span>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Fecha y Hora</div>
                        <div class="event-detail-value">
                            <?php if ($actividad['fecha']): ?>
                                <?= date('d/m/Y', strtotime($actividad['fecha'])) ?>
                                <?= $actividad['hora'] ? ' - ' . date('H:i', strtotime($actividad['hora'])) : '' ?>
                            <?php else: ?>
                                <span class="text-muted">No definida</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Duración</div>
                        <div class="event-detail-value">
                            <?= $actividad['duracion'] ? "{$actividad['duracion']} minutos" : '<span class="text-muted">No definida</span>' ?>
                        </div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Sede</div>
                        <div class="event-detail-value">
                            <?= esc($actividad['sede']['denominacion'] ?? '<span class="text-muted">No asignada</span>') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Modalidad</div>
                        <div class="event-detail-value">
                            <?= esc($actividad['modalidad']['modalidad'] ?? '<span class="text-muted">No asignada</span>') ?>
                        </div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Descripción</div>
                        <div class="event-detail-value">
                            <?= $actividad['descripcion'] ? nl2br(esc($actividad['descripcion'])) : '<span class="text-muted">Sin descripción</span>' ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <hr>

        <div class="row text-muted small">
            <div class="col-md-6">
                <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($actividad['created_at'])) ?></p>
            </div>
            <div class="col-md-6">
                <?php if ($actividad['updated_at']): ?>
                    <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($actividad['updated_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("actividades/editar/{$actividad['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('actividades') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al listado
    </a>
</div>

<style>
    .event-detail-item {
        display: flex;
        margin-bottom: 1.5rem;
        align-items: flex-start;
    }

    .event-detail-icon {
        width: 40px;
        text-align: center;
        color: #6c757d;
        margin-right: 1rem;
        font-size: 1.2rem;
    }

    .event-detail-content {
        flex: 1;
    }

    .event-detail-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
        font-size: 0.9rem;
    }

    .event-detail-value {
        color: #6c757d;
        font-size: 1rem;
    }

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
</style>
<?php $this->endSection() ?>