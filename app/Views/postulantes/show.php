<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📄 Detalle del Postulante</h2>
        <p class="az-dashboard-text">Información completa del postulante seleccionado</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <?php if ($postulante['url_foto']): ?>
                    <img src="<?= base_url($postulante['url_foto']) ?>" alt="Foto" class="img-fluid rounded-circle mb-3" style="max-height: 200px;">
                <?php else: ?>
                    <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 200px; height: 200px;">
                        <i class="fas fa-user text-white fa-4x"></i>
                    </div>
                <?php endif; ?>
                <h4><?= esc($postulante['nombre']) ?> <?= esc($postulante['apellido']) ?></h4>
                <p class="text-muted">ID: #<?= $postulante['id'] ?></p>
                <p class="text-muted">DNI: <?= esc($postulante['dni']) ?></p>
                <?php if (isset($edad)): ?>
                    <p class="text-muted">Edad: <?= $edad ?> años</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <!-- Pestañas para mostrar toda la información -->
        <div class="card shadow-sm">
            <div class="card-body">
                <ul class="nav nav-tabs mb-4" id="postulanteTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="personal-tab" data-bs-toggle="tab" data-bs-target="#personal" type="button" role="tab">
                            <i class="fas fa-user me-1"></i> Información Personal
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="academica-tab" data-bs-toggle="tab" data-bs-target="#academica" type="button" role="tab">
                            <i class="fas fa-graduation-cap me-1"></i> Formación Académica
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="laboral-tab" data-bs-toggle="tab" data-bs-target="#laboral" type="button" role="tab">
                            <i class="fas fa-briefcase me-1"></i> Experiencia Laboral
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contacto-tab" data-bs-toggle="tab" data-bs-target="#contacto" type="button" role="tab">
                            <i class="fas fa-address-book me-1"></i> Contacto
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
                            <i class="fas fa-file-alt me-1"></i> Documentación
                        </button>
                    </li>
                </ul>

                <div class="tab-content" id="postulanteTabsContent">
                    <!-- Pestaña Información Personal -->
                    <div class="tab-pane fade show active" id="personal" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Fecha de Nacimiento:</strong><br>
                                <?= $postulante['fecha_nacimiento'] ? date('d/m/Y', strtotime($postulante['fecha_nacimiento'])) : 'No especificada' ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Estado Civil:</strong><br>
                                <?= esc($postulante['estado_civil'] ?? 'No especificado') ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Nacionalidad:</strong><br>
                                <?= esc($postulante['nacionalidad'] ?? 'No especificada') ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Domicilio:</strong><br>
                                <?= esc($postulante['domicilio'] ?? 'No especificado') ?>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Formación Académica -->
                    <div class="tab-pane fade" id="academica" role="tabpanel">
                        <div class="mb-3">
                            <strong>Título Universitario:</strong><br>
                            <?= esc($postulante['titulo'] ?? 'No especificado') ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Fecha de Título:</strong><br>
                                <?= $postulante['fecha_titulo'] ? date('d/m/Y', strtotime($postulante['fecha_titulo'])) : 'No especificada' ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Fecha de Matriculación:</strong><br>
                                <?= $postulante['fecha_matriculacion'] ? date('d/m/Y', strtotime($postulante['fecha_matriculacion'])) : 'No especificada' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Experiencia Laboral -->
                    <div class="tab-pane fade" id="laboral" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Antigüedad ejercicio profesional letrado:</strong><br>
                                <?= $postulante['antiguedad_ejercicio_profesional_letrado'] ? date('d/m/Y', strtotime($postulante['antiguedad_ejercicio_profesional_letrado'])) : 'No especificada' ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Antigüedad ejercicio profesional matriculación:</strong><br>
                                <?= $postulante['antiguedad_ejercicio_profesional_matriculacion'] ? date('d/m/Y', strtotime($postulante['antiguedad_ejercicio_profesional_matriculacion'])) : 'No especificada' ?>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Contacto -->
                    <div class="tab-pane fade" id="contacto" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <strong>Teléfonos:</strong><br>
                                <?php if (!empty($telefonos)): ?>
                                    <?php foreach ($telefonos as $telefono): ?>
                                        <span class="badge bg-primary me-1 mb-1"><?= esc($telefono['numero']) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin teléfonos registrados</span>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 mb-3">
                                <strong>Emails:</strong><br>
                                <?php if (!empty($emails)): ?>
                                    <?php foreach ($emails as $email): ?>
                                        <span class="badge bg-success me-1 mb-1"><?= esc($email['direccion']) ?></span>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <span class="text-muted">Sin emails registrados</span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- Pestaña Documentación -->
                    <div class="tab-pane fade" id="documentos" role="tabpanel">
                        <div class="document-status mb-2">
                            <div>
                                <strong>Foto Carnet 4x4:</strong>
                            </div>
                            <div>
                                <?php if ($postulante['d_foto_carnet']): ?>
                                    <span class="badge bg-success">Presentada</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">No presentada</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Certificado de Buena Conducta Provincial:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_buena_conducta'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_buena_conducta'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_buena_conducta'], 10) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Constancia de Antigüedad:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_antiguedad'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_antiguedad'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_antiguedad'], 180) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Constancia de Sanciones:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_sanciones'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_sanciones'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_sanciones'], 180) ?>
                            </div>
                        </div>

                        <?php if ($postulante['d_sanciones_descripcion']): ?>
                            <div class="mb-3">
                                <strong>Descripción de Sanciones:</strong><br>
                                <?= nl2br(esc($postulante['d_sanciones_descripcion'])) ?>
                            </div>
                        <?php endif; ?>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Constancia de Matrícula:</strong>
                            </div>
                            <div>
                                <?php if ($postulante['d_matricula']): ?>
                                    <span class="badge bg-success">Presentada</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">No presentada</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>RE.D.A.M.:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_redam'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_redam'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_redam'], 60) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>R.U.P.V.:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_rupv'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_rupv'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_rupv'], 60) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Certificado Psicofísico:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['psicofisico'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['psicofisico'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['psicofisico'], 180) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Certificado de Domicilio:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_certificado_domicilio'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_certificado_domicilio'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_certificado_domicilio'], 10) ?>
                            </div>
                        </div>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Información Sumaria:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['d_informacion_sumaria'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['d_informacion_sumaria'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['d_informacion_sumaria'], 365) ?>
                            </div>
                        </div>

                        <?php if ($postulante['d_informacion_sumaria_descripcion']): ?>
                            <div class="mb-3">
                                <strong>Descripción de Información Sumaria:</strong><br>
                                <?= nl2br(esc($postulante['d_informacion_sumaria_descripcion'])) ?>
                            </div>
                        <?php endif; ?>

                        <div class="document-status mb-2">
                            <div>
                                <strong>Estudios Psicofísicos:</strong>
                                <div class="vigencia-text">
                                    <?= $postulante['estudios_psicofisicos_fecha'] ? 'Fecha: ' . date('d/m/Y', strtotime($postulante['estudios_psicofisicos_fecha'])) : 'No presentado' ?>
                                </div>
                            </div>
                            <div>
                                <?= $this->verificarVigenciaDocumento($postulante['estudios_psicofisicos_fecha'], 730) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <p><strong>Fecha de creación:</strong> <?= date('d/m/Y H:i', strtotime($postulante['created_at'])) ?></p>
                <?php if ($postulante['updated_at'] && $postulante['updated_at'] != $postulante['created_at']): ?>
                    <p><strong>Última actualización:</strong> <?= date('d/m/Y H:i', strtotime($postulante['updated_at'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="<?= base_url("postulantes/editar/{$postulante['id']}") ?>" class="btn btn-warning">
        <i class="fas fa-edit"></i> Editar
    </a>
    <a href="<?= base_url('postulantes') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver al Listado
    </a>
</div>

<style>
    .document-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.75rem;
        border: 1px solid #e0e0e0;
        border-radius: 0.375rem;
        margin-bottom: 0.5rem;
    }

    .vigencia-text {
        font-size: 0.8rem;
        color: #6c757d;
    }
</style>

<?php $this->endSection() ?>

<?php
// Función helper para verificar vigencia de documentos
if (!function_exists('verificarVigenciaDocumento')) {
    function verificarVigenciaDocumento($fechaDocumento, $diasVigencia)
    {
        if (!$fechaDocumento) {
            return '<span class="badge bg-secondary">No presentado</span>';
        }

        $fechaDoc = new DateTime($fechaDocumento);
        $hoy = new DateTime();
        $fechaVencimiento = clone $fechaDoc;
        $fechaVencimiento->modify("+{$diasVigencia} days");

        $diasRestantes = $hoy->diff($fechaVencimiento)->days;

        if ($fechaVencimiento < $hoy) {
            return '<span class="badge bg-danger">Vencido</span>';
        } elseif ($diasRestantes <= 7) {
            return '<span class="badge bg-warning">Por vencer (' . $diasRestantes . ' días)</span>';
        } else {
            return '<span class="badge bg-success">Vigente (' . $diasRestantes . ' días)</span>';
        }
    }
}
?>