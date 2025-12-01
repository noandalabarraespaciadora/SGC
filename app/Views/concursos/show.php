<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Concurso</h2>
        <p class="az-dashboard-text">Información completa del concurso seleccionado</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h4 class="mb-1"><?= esc($concurso['caratula']) ?></h4>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-primary"><?= esc($concurso['numero_expediente']) ?></span>
                            <?php if ($concurso['estado_nombre'] ?? false): ?>
                                <span class="badge estado-<?= $concurso['estado_nombre'] ?>">
                                    <?= esc($concurso['estado_nombre']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div>
                        <a href="<?= base_url("concursos/editar/{$concurso['id']}") ?>" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6>Información del Concurso</h6>
                        <div class="concurso-meta">
                            <?php if ($concurso['resolucionSTJ']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Resolución STJ:</span>
                                    <span class="concurso-meta-value"><?= esc($concurso['resolucionSTJ']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['comunicacionCM']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Comunicación CM:</span>
                                    <span class="concurso-meta-value"><?= esc($concurso['comunicacionCM']) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['fecha_edicto_publicacion']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Fecha Edicto:</span>
                                    <span class="concurso-meta-value"><?= date('d/m/Y', strtotime($concurso['fecha_edicto_publicacion'])) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['unificado_nombre'] ?? false): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Unificado:</span>
                                    <span class="concurso-meta-value"><?= esc($concurso['unificado_nombre']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <h6>Fechas de Exámenes</h6>
                        <div class="concurso-meta">
                            <?php if ($concurso['fecha_escrito']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Examen Escrito:</span>
                                    <span class="concurso-meta-value"><?= date('d/m/Y H:i', strtotime($concurso['fecha_escrito'])) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['fecha_oral']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Examen Oral:</span>
                                    <span class="concurso-meta-value"><?= date('d/m/Y H:i', strtotime($concurso['fecha_oral'])) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['propuestas_fecha']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Fecha Propuestas:</span>
                                    <span class="concurso-meta-value"><?= date('d/m/Y', strtotime($concurso['propuestas_fecha'])) ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($concurso['propuestas_nro_oficio']): ?>
                                <div class="concurso-meta-item">
                                    <span class="concurso-meta-label">Oficio Propuestas:</span>
                                    <span class="concurso-meta-value"><?= esc($concurso['propuestas_nro_oficio']) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <?php if ($concurso['resultadoVotacion']): ?>
                    <div class="alert alert-success mb-3">
                        <strong>Resultado de Votación:</strong> <?= esc($concurso['resultadoVotacion']) ?>
                    </div>
                <?php endif; ?>

                <?php if ($concurso['observaciones']): ?>
                    <div class="mb-3">
                        <h6>Observaciones</h6>
                        <div class="card card-body bg-light">
                            <?= nl2br(esc($concurso['observaciones'])) ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h6>Estadísticas</h6>
                <div class="concurso-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?= $concurso['estadisticas']['total_postulantes'] ?? 0 ?></div>
                        <div class="stat-label">Postulantes</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= $concurso['estadisticas']['total_comision'] ?? 0 ?></div>
                        <div class="stat-label">Comisión</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= $concurso['estadisticas']['titulares'] ?? 0 ?></div>
                        <div class="stat-label">Titulares</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?= $concurso['estadisticas']['suplentes'] ?? 0 ?></div>
                        <div class="stat-label">Suplentes</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <h6>Comisión Examinadora</h6>
                <div class="concurso-meta">
                    <?php if (!empty($concurso['comision'])): ?>
                        <?php foreach ($concurso['comision'] as $miembro): ?>
                            <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                                <div>
                                    <strong><?= esc($miembro['docente_nombre'] ?? 'Desconocido') ?></strong><br>
                                    <small class="text-muted">
                                        <?= esc($miembro['representacion_nombre'] ?? 'Sin representación') ?>
                                        - <?= ucfirst(esc($miembro['condicion'] ?? 'titular')) ?>
                                    </small>
                                </div>
                                <?php if (($miembro['condicion'] ?? '') == 'renuncio'): ?>
                                    <span class="badge bg-danger">Renunció</span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-muted">No hay comisión asignada</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card shadow-sm mt-4">
    <div class="card-body">
        <h6>Postulantes</h6>
        <?php if (!empty($concurso['postulantes'])): ?>
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Postulante</th>
                            <th>Nivel de Excelencia</th>
                            <th>Reserva Examen</th>
                            <th>Reserva Estudios Médicos</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($concurso['postulantes'] as $postulante): ?>
                            <tr>
                                <td>ID: <?= $postulante['id_postulante'] ?? 'N/A' ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= esc($postulante['nivel_codigo'] ?? 'Sin nivel') ?>
                                    </span>
                                    <small><?= esc($postulante['nivel_nombre'] ?? '') ?></small>
                                </td>
                                <td><?= esc($postulante['reservaExamen'] ?? '-') ?></td>
                                <td><?= esc($postulante['reservaEstudiosMedicos'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-muted">No hay postulantes registrados</p>
        <?php endif; ?>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url('concursos') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<style>
    .concurso-meta {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
    }

    .concurso-meta-item {
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        display: flex;
        justify-content: space-between;
    }

    .concurso-meta-item:last-child {
        margin-bottom: 0;
    }

    .concurso-meta-label {
        font-weight: 600;
        color: #495057;
    }

    .concurso-meta-value {
        color: #6c757d;
        text-align: right;
    }

    .concurso-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.5rem;
    }

    .stat-item {
        text-align: center;
        padding: 0.5rem;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .stat-number {
        font-size: 1.1rem;
        font-weight: 700;
        color: #2c3e50;
    }

    .stat-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .estado-Con {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .estado-Dictamen {
        background: #fff3e0;
        color: #ef6c00;
    }

    .estado-Examen {
        background: #e3f2fd;
        color: #1565c0;
    }

    .estado-Provisorio {
        background: #fce4ec;
        color: #c2185b;
    }

    .estado-Sin {
        background: #fff8e1;
        color: #ff8f00;
    }
</style>
<?php $this->endSection() ?>