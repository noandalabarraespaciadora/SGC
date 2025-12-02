<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">👤 Crear Nuevo Postulante</h2>
        <p class="az-dashboard-text">Complete todos los campos obligatorios para registrar un nuevo postulante</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-info btn-sm" id="btnVistaPrevia">
            <i class="fas fa-eye me-1"></i> Vista Previa
        </button>
        <button class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalValidezRequisitos">
            <i class="fas fa-info-circle me-1"></i> Validez de los Requisitos
        </button>
        <a href="<?= base_url('postulantes') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver al Listado
        </a>
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
                <button class="nav-link" id="documentos-tab" data-bs-toggle="tab" data-bs-target="#documentos" type="button" role="tab">
                    <i class="fas fa-file-alt me-1"></i> Documentación Presentada
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="psicofisico-tab" data-bs-toggle="tab" data-bs-target="#psicofisico_tab" type="button" role="tab">
                    <i class="fas fa-stethoscope me-1"></i> Psicofísico
                </button>
            </li>
        </ul>

        <form method="post" action="<?= base_url('postulantes/crear') ?>" enctype="multipart/form-data" id="postulanteForm">
            <?= csrf_field() ?>

            <div class="tab-content" id="postulanteTabsContent">
                <!-- Pestaña Información Personal -->
                <div class="tab-pane fade show active" id="personal" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="apellido" class="form-label">Apellido <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="apellido" name="apellido"
                                value="<?= old('apellido') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?= old('nombre') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dni" class="form-label">DNI <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="dni" name="dni"
                                value="<?= old('dni') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento"
                                value="<?= old('fecha_nacimiento') ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="domicilio" class="form-label">Domicilio <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio"
                                value="<?= old('domicilio') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="estado_civil" class="form-label">Estado Civil <span class="text-danger">*</span></label>
                            <select class="form-control" id="estado_civil" name="estado_civil" required>
                                <option value="">Seleccione...</option>
                                <option value="Soltero/a" <?= old('estado_civil') == 'Soltero/a' ? 'selected' : '' ?>>Soltero/a</option>
                                <option value="Casado/a" <?= old('estado_civil') == 'Casado/a' ? 'selected' : '' ?>>Casado/a</option>
                                <option value="Viudo/a" <?= old('estado_civil') == 'Viudo/a' ? 'selected' : '' ?>>Viudo/a</option>
                                <option value="Divorciado/a" <?= old('estado_civil') == 'Divorciado/a' ? 'selected' : '' ?>>Divorciado/a</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nacionalidad" class="form-label">Nacionalidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad"
                                value="<?= old('nacionalidad') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Foto</label>
                            <div class="photo-upload mb-3" id="photoUpload">
                                <i class="fas fa-cloud-upload-alt fa-2x text-muted mb-2"></i>
                                <p class="mb-0">Haga clic para subir una foto</p>
                                <small class="text-muted">Formatos: JPG, PNG (Máx. 2MB)</small>
                            </div>
                            <input type="file" id="photoInput" name="url_foto" accept="image/*" class="d-none">

                            <div id="photoPreview" class="d-none">
                                <img src="" alt="Vista previa" class="img-fluid rounded mb-2" id="previewImage" style="max-height: 150px;">
                                <button type="button" class="btn btn-sm btn-outline-danger" id="removePhoto">
                                    <i class="fas fa-trash me-1"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfonos <span class="text-danger">*</span></label>
                            <div id="telefonos-container">
                                <div class="input-group mb-2">
                                    <input type="tel" class="form-control" name="telefonos[]" placeholder="Ej: 3624-123456"
                                        value="<?= old('telefonos.0') ?>" required>
                                    <button type="button" class="btn btn-outline-success btn-agregar-telefono" data-type="telefono">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Emails <span class="text-danger">*</span></label>
                            <div id="emails-container">
                                <div class="input-group mb-2">
                                    <input type="email" class="form-control" name="emails[]" placeholder="Ej: ejemplo@dominio.com"
                                        value="<?= old('emails.0') ?>" required>
                                    <button type="button" class="btn btn-outline-success btn-agregar-email" data-type="email">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pestaña Formación Académica -->
                <div class="tab-pane fade" id="academica" role="tabpanel">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título Universitario</label>
                        <input type="text" class="form-control" id="titulo" name="titulo"
                            value="<?= old('titulo') ?>">
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_titulo" class="form-label">Fecha de Título</label>
                            <input type="date" class="form-control" id="fecha_titulo" name="fecha_titulo"
                                value="<?= old('fecha_titulo') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="fecha_matriculacion" class="form-label">Fecha de Matriculación</label>
                            <input type="date" class="form-control" id="fecha_matriculacion" name="fecha_matriculacion"
                                value="<?= old('fecha_matriculacion') ?>">
                        </div>
                    </div>
                </div>

                <!-- Pestaña Experiencia Laboral -->
                <div class="tab-pane fade" id="laboral" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="antiguedad_ejercicio_profesional_letrado" class="form-label">Antigüedad en el ejercicio de la Profesión Letrado</label>
                            <input type="date" class="form-control" id="antiguedad_ejercicio_profesional_letrado"
                                name="antiguedad_ejercicio_profesional_letrado"
                                value="<?= old('antiguedad_ejercicio_profesional_letrado') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="antiguedad_ejercicio_profesional_matriculacion" class="form-label">Antigüedad en el ejercicio profesional matriculación</label>
                            <input type="date" class="form-control" id="antiguedad_ejercicio_profesional_matriculacion"
                                name="antiguedad_ejercicio_profesional_matriculacion"
                                value="<?= old('antiguedad_ejercicio_profesional_matriculacion') ?>">
                        </div>
                    </div>
                </div>

                <!-- Pestaña Documentación Presentada -->
                <div class="tab-pane fade" id="documentos" role="tabpanel">
                    <div class="document-status" id="d_foto_carnet_status">
                        <div>
                            <strong>Foto Carnet 4x4</strong>
                            <div class="vigencia-text">Obligatoria para el registro</div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="d_foto_carnet" name="d_foto_carnet"
                                    <?= old('d_foto_carnet') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="d_foto_carnet">
                                    Presentada
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="document-status" id="d_buena_conducta_status">
                        <div>
                            <strong>Certificado de Buena Conducta Provincial</strong>
                            <div class="vigencia-text">Validez: 10 días</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_buena_conducta"
                                name="d_buena_conducta" value="<?= old('d_buena_conducta') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="d_antiguedad_status">
                        <div>
                            <strong>Constancia de Antigüedad en el Poder Judicial</strong>
                            <div class="vigencia-text">Validez: 6 meses</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_antiguedad"
                                name="d_antiguedad" value="<?= old('d_antiguedad') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="d_sanciones_status">
                        <div>
                            <strong>Constancia de Sanciones en el Poder Judicial</strong>
                            <div class="vigencia-text">Validez: 6 meses</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_sanciones"
                                name="d_sanciones" value="<?= old('d_sanciones') ?>">
                        </div>
                    </div>

                    <!-- Campo para Descripción de Sanciones -->
                    <div class="mb-3" id="sanciones_descripcion_container" style="display: none;">
                        <label for="d_sanciones_descripcion" class="form-label">Descripción de Sanciones</label>
                        <textarea class="form-control" id="d_sanciones_descripcion" name="d_sanciones_descripcion"
                            rows="3" placeholder="Describa las sanciones informadas en la constancia presentada"><?= old('d_sanciones_descripcion') ?></textarea>
                    </div>

                    <div class="document-status" id="d_matricula_status">
                        <div>
                            <strong>Constancia de inscripción en la Matrícula</strong>
                            <div class="vigencia-text">Validez: 6 meses</div>
                        </div>
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="d_matricula" name="d_matricula"
                                    <?= old('d_matricula') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="d_matricula">
                                    Presentado
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="document-status" id="d_redam_status">
                        <div>
                            <strong>Registro de Deudores Alimentarios Morosos (RE.D.A.M.)</strong>
                            <div class="vigencia-text">Validez: 60 días</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_redam"
                                name="d_redam" value="<?= old('d_redam') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="d_rupv_status">
                        <div>
                            <strong>Registro Único de Personas Violentas (R.U.P.V.)</strong>
                            <div class="vigencia-text">Validez: 60 días</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_rupv"
                                name="d_rupv" value="<?= old('d_rupv') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="psicofisico_status">
                        <div>
                            <strong>Constancia de Aptitud Psicofísico (Certif. Buena Salud)</strong>
                            <div class="vigencia-text">Validez: 6 meses</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="psicofisico"
                                name="psicofisico" value="<?= old('psicofisico') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="d_certificado_domicilio_status">
                        <div>
                            <strong>Certificado de Domicilio</strong>
                            <div class="vigencia-text">Validez: 10 días</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_certificado_domicilio"
                                name="d_certificado_domicilio" value="<?= old('d_certificado_domicilio') ?>">
                        </div>
                    </div>

                    <div class="document-status" id="d_informacion_sumaria_status">
                        <div>
                            <strong>Información Sumaria de Residencia (Sólo para Juzgados de Paz y Faltas)</strong>
                            <div class="vigencia-text">Validez: 1 año</div>
                        </div>
                        <div>
                            <input type="date" class="form-control form-control-sm" id="d_informacion_sumaria"
                                name="d_informacion_sumaria" value="<?= old('d_informacion_sumaria') ?>">
                        </div>
                    </div>

                    <!-- Campo para Descripción de Información Sumaria -->
                    <div class="mb-3" id="informacion_sumaria_descripcion_container" style="display: none;">
                        <label for="d_informacion_sumaria_descripcion" class="form-label">Descripción de Información Sumaria</label>
                        <textarea class="form-control" id="d_informacion_sumaria_descripcion" name="d_informacion_sumaria_descripcion"
                            rows="3" placeholder="Describa la información sumaria registrada"><?= old('d_informacion_sumaria_descripcion') ?></textarea>
                    </div>
                </div>

                <!-- Nueva Pestaña Psicofísico -->
                <div class="tab-pane fade" id="psicofisico_tab" role="tabpanel">
                    <div class="form-section">
                        <h5 class="form-section-title">Estudios Psicofísicos</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="estudios_psicofisicos_fecha" class="form-label">Fecha de Estudios Psicofísicos</label>
                                <input type="date" class="form-control" id="estudios_psicofisicos_fecha"
                                    name="estudios_psicofisicos_fecha" value="<?= old('estudios_psicofisicos_fecha') ?>">
                                <div class="form-text">Vigencia: 2 años</div>
                            </div>
                        </div>
                        <div class="document-status" id="estudios_psicofisicos_status">
                            <div>
                                <strong>Estado de los Estudios Psicofísicos</strong>
                                <div class="vigencia-text" id="estudios_psicofisicos_vigencia_text">-</div>
                            </div>
                            <div>
                                <span class="badge bg-secondary" id="estudios_psicofisicos_estado">Sin datos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <button type="button" class="btn btn-outline-secondary" id="btnCancelar">
                    <i class="fas fa-times me-1"></i> Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar Postulante
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Validez de Requisitos -->
<div class="modal fade" id="modalValidezRequisitos" tabindex="-1" aria-labelledby="modalValidezRequisitosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalValidezRequisitosLabel">Validez de los Requisitos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Documento</th>
                                <th>Vigencia</th>
                                <th>Observaciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Certificado de Buena Conducta Provincial</td>
                                <td>10 días</td>
                                <td>Debe estar vigente al momento de la presentación</td>
                            </tr>
                            <tr>
                                <td>Constancia de Antigüedad y Sanciones en el Poder Judicial</td>
                                <td>6 meses</td>
                                <td>Debe incluir constancia de no tener sanciones</td>
                            </tr>
                            <tr>
                                <td>Constancia de inscripción en la Matrícula</td>
                                <td>6 meses</td>
                                <td>Debe estar al día con las obligaciones profesionales</td>
                            </tr>
                            <tr>
                                <td>Registro de Deudores Alimentarios Morosos (RE.D.A.M.)</td>
                                <td>60 días</td>
                                <td>Constancia de no estar registrado como deudor alimentario moroso
                                    <a href="https://tramites.chaco.gob.ar/tramite/64/Solicitud-de-certificado-del-ReDAM-Registro-de-Deudores-Alimentarios-Morosos" target="_blank"> Guia de Trámites </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Registro Único de Personas Violentas (R.U.P.V.)</td>
                                <td>60 días</td>
                                <td>Constancia de no estar registrado como persona violenta
                                    <a href="https://tramites.chaco.gob.ar/tramite/Solicitud-certificado-del-RUPV-Registro-Unico-de-Personas-Violentas" target="_blank"> Guia de Trámites </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Constancia de Aptitud Psicofísico</td>
                                <td>6 meses</td>
                                <td>Emitido por profesional médico habilitado</td>
                            </tr>
                            <tr>
                                <td>Certificado de Domicilio</td>
                                <td>10 días</td>
                                <td>Debe coincidir con el domicilio declarado</td>
                            </tr>
                            <tr>
                                <td>Información Sumaria de Residencia</td>
                                <td>1 año</td>
                                <td>Sólo para Juzgados de Paz y Faltas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Vista Previa -->
<div class="modal fade" id="modalVistaPrevia" tabindex="-1" aria-labelledby="modalVistaPreviaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalVistaPreviaLabel">Vista Previa del Postulante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <img src="<?= base_url('img/faces/face1.jpg') ?>" alt="Foto" class="avatar-xl rounded-circle mb-3" id="previewPhoto">
                        <h5 id="previewNombreCompleto">Nombre del postulante</h5>
                        <p class="text-muted" id="previewEdad">Edad</p>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <strong>DNI:</strong> <span id="previewDni">-</span>
                        </div>
                        <div class="mb-3">
                            <strong>Domicilio:</strong> <span id="previewDomicilio">-</span>
                        </div>
                        <div class="mb-3">
                            <strong>Estado Civil:</strong> <span id="previewEstadoCivil">-</span>
                        </div>
                        <div class="mb-3">
                            <strong>Nacionalidad:</strong> <span id="previewNacionalidad">-</span>
                        </div>
                        <div class="mb-3">
                            <strong>Fecha de Nacimiento:</strong> <span id="previewFechaNacimiento">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style>
    .photo-upload {
        border: 2px dashed #dee2e6;
        border-radius: 0.5rem;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
    }

    .photo-upload:hover {
        border-color: #007bff;
        background-color: #f8f9fa;
    }

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

    .vigencia-vencida {
        border-color: #dc3545;
        background-color: rgba(220, 53, 69, 0.05);
    }

    .vigencia-proxima {
        border-color: #ffc107;
        background-color: rgba(255, 193, 7, 0.05);
    }

    .vigencia-ok {
        border-color: #198754;
        background-color: rgba(25, 135, 84, 0.05);
    }

    .btn-agregar-contacto {
        border-top-left-radius: 0;
        border-bottom-left-radius: 0;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Control del menú móvil
        $('#azMenuShow').on('click', function(e) {
            e.preventDefault();
            $('#azHeaderMenu').addClass('show');
            $('#azOverlay').addClass('show');
        });

        $('#azMenuClose, #azOverlay').on('click', function(e) {
            e.preventDefault();
            $('#azHeaderMenu').removeClass('show');
            $('#azOverlay').removeClass('show');
        });

        // Script para manejar la subida de fotos
        $('#photoUpload').on('click', function() {
            $('#photoInput').click();
        });

        $('#photoInput').on('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#photoUpload').addClass('d-none');
                    $('#photoPreview').removeClass('d-none');
                }

                reader.readAsDataURL(e.target.files[0]);

                // Marcar automáticamente el checkbox de foto carnet
                $('#d_foto_carnet').prop('checked', true);
            }
        });

        $('#removePhoto').on('click', function() {
            $('#photoInput').val('');
            $('#photoPreview').addClass('d-none');
            $('#photoUpload').removeClass('d-none');
            // Desmarcar el checkbox de foto carnet
            $('#d_foto_carnet').prop('checked', false);
        });

        // Mostrar/ocultar descripción de sanciones cuando se ingresa fecha
        $('#d_sanciones').on('change', function() {
            if ($(this).val()) {
                $('#sanciones_descripcion_container').slideDown();
            } else {
                $('#sanciones_descripcion_container').slideUp();
            }
        });

        // Mostrar/ocultar descripción de información sumaria cuando se ingresa fecha
        $('#d_informacion_sumaria').on('change', function() {
            if ($(this).val()) {
                $('#informacion_sumaria_descripcion_container').slideDown();
            } else {
                $('#informacion_sumaria_descripcion_container').slideUp();
            }
        });

        // Actualizar estado de estudios psicofísicos
        function actualizarEstadoEstudiosPsicofisicos() {
            const fechaEstudios = $('#estudios_psicofisicos_fecha').val();
            const estado = verificarVigencia(fechaEstudios, 730); // 2 años = 730 días

            $('#estudios_psicofisicos_status').removeClass('vigencia-vencida vigencia-proxima vigencia-ok');

            if (fechaEstudios) {
                const fechaDoc = new Date(fechaEstudios);
                const hoy = new Date();
                const fechaVencimiento = new Date(fechaDoc);
                fechaVencimiento.setDate(fechaVencimiento.getDate() + 730);

                const diasRestantes = Math.ceil((fechaVencimiento - hoy) / (1000 * 60 * 60 * 24));

                $('#estudios_psicofisicos_vigencia_text').text(`Días restantes: ${diasRestantes}`);

                if (diasRestantes < 0) {
                    $('#estudios_psicofisicos_status').addClass('vigencia-vencida');
                    $('#estudios_psicofisicos_estado').removeClass('bg-secondary bg-warning bg-success').addClass('bg-danger').text('Vencido');
                } else if (diasRestantes <= 30) {
                    $('#estudios_psicofisicos_status').addClass('vigencia-proxima');
                    $('#estudios_psicofisicos_estado').removeClass('bg-secondary bg-danger bg-success').addClass('bg-warning').text('Por vencer');
                } else {
                    $('#estudios_psicofisicos_status').addClass('vigencia-ok');
                    $('#estudios_psicofisicos_estado').removeClass('bg-secondary bg-danger bg-warning').addClass('bg-success').text('Vigente');
                }
            } else {
                $('#estudios_psicofisicos_vigencia_text').text('-');
                $('#estudios_psicofisicos_estado').removeClass('bg-warning bg-danger bg-success').addClass('bg-secondary').text('Sin datos');
            }
        }

        // Actualizar estado cuando cambie la fecha de estudios psicofísicos
        $('#estudios_psicofisicos_fecha').on('change', function() {
            actualizarEstadoEstudiosPsicofisicos();
        });

        // Inicializar estado de estudios psicofísicos
        actualizarEstadoEstudiosPsicofisicos();

        // Validación de vigencia de documentos
        function verificarVigencia(fecha, diasVigencia) {
            if (!fecha) return 'sin-dato';

            const fechaDoc = new Date(fecha);
            const hoy = new Date();
            const fechaVencimiento = new Date(fechaDoc);
            fechaVencimiento.setDate(fechaVencimiento.getDate() + diasVigencia);

            const diasRestantes = Math.ceil((fechaVencimiento - hoy) / (1000 * 60 * 60 * 24));

            if (diasRestantes < 0) return 'vencida';
            if (diasRestantes <= 7) return 'proxima';
            return 'ok';
        }

        function actualizarEstadoDocumentos() {
            // Certificado de Buena Conducta (10 días)
            const estadoBuenaConducta = verificarVigencia($('#d_buena_conducta').val(), 10);
            actualizarEstiloDocumento('#d_buena_conducta_status', estadoBuenaConducta);

            // Constancia de Antigüedad (180 días)
            const estadoAntiguedad = verificarVigencia($('#d_antiguedad').val(), 180);
            actualizarEstiloDocumento('#d_antiguedad_status', estadoAntiguedad);

            // RE.D.A.M. (60 días)
            const estadoRedam = verificarVigencia($('#d_redam').val(), 60);
            actualizarEstiloDocumento('#d_redam_status', estadoRedam);

            // R.U.P.V. (60 días)
            const estadoRupv = verificarVigencia($('#d_rupv').val(), 60);
            actualizarEstiloDocumento('#d_rupv_status', estadoRupv);

            // Psicofísico (180 días)
            const estadoPsicofisico = verificarVigencia($('#psicofisico').val(), 180);
            actualizarEstiloDocumento('#psicofisico_status', estadoPsicofisico);

            // Información Sumaria (365 días)
            const estadoInfoSumaria = verificarVigencia($('#d_informacion_sumaria').val(), 365);
            actualizarEstiloDocumento('#d_informacion_sumaria_status', estadoInfoSumaria);

            // Certificado de Domicilio (10 días)
            const estadoCertificadoDomicilio = verificarVigencia($('#d_certificado_domicilio').val(), 10);
            actualizarEstiloDocumento('#d_certificado_domicilio_status', estadoCertificadoDomicilio);

            // Foto Carnet (booleano)
            actualizarEstiloDocumento('#d_foto_carnet_status', $('#d_foto_carnet').is(':checked') ? 'ok' : 'sin-dato');

            // Constancia de Sanciones (180 días)
            const estadoSanciones = verificarVigencia($('#d_sanciones').val(), 180);
            actualizarEstiloDocumento('#d_sanciones_status', estadoSanciones);

            // Para documentos booleanos (matrícula y certificado de domicilio)
            actualizarEstiloDocumento('#d_matricula_status', $('#d_matricula').is(':checked') ? 'ok' : 'sin-dato');
        }

        function actualizarEstiloDocumento(selector, estado) {
            $(selector).removeClass('vigencia-vencida vigencia-proxima vigencia-ok');

            switch (estado) {
                case 'vencida':
                    $(selector).addClass('vigencia-vencida');
                    break;
                case 'proxima':
                    $(selector).addClass('vigencia-proxima');
                    break;
                case 'ok':
                    $(selector).addClass('vigencia-ok');
                    break;
                default:
                    // Sin datos - sin estilo especial
                    break;
            }
        }

        // Actualizar estado de documentos cuando cambien las fechas
        $('input[type="date"], input[type="checkbox"]').on('change', function() {
            actualizarEstadoDocumentos();
        });

        // Inicializar estado de documentos
        actualizarEstadoDocumentos();

        // Vista Previa
        $('#btnVistaPrevia').on('click', function() {
            const apellido = $('#apellido').val() || '-';
            const nombre = $('#nombre').val() || '-';
            const dni = $('#dni').val() || '-';
            const domicilio = $('#domicilio').val() || '-';
            const estadoCivil = $('#estado_civil').val() || '-';
            const nacionalidad = $('#nacionalidad').val() || '-';
            const fechaNacimiento = $('#fecha_nacimiento').val();

            // Actualizar datos en el modal
            $('#previewNombreCompleto').text(`${nombre} ${apellido}`);
            $('#previewDni').text(dni);
            $('#previewDomicilio').text(domicilio);
            $('#previewEstadoCivil').text(estadoCivil);
            $('#previewNacionalidad').text(nacionalidad);
            $('#previewFechaNacimiento').text(fechaNacimiento || '-');

            // Calcular y mostrar edad
            if (fechaNacimiento) {
                const hoy = new Date();
                const nacimiento = new Date(fechaNacimiento);
                let edad = hoy.getFullYear() - nacimiento.getFullYear();
                const mes = hoy.getMonth() - nacimiento.getMonth();

                if (mes < 0 || (mes === 0 && hoy.getDate() < nacimiento.getDate())) {
                    edad--;
                }

                $('#previewEdad').text(`${edad} años`);
            } else {
                $('#previewEdad').text('Edad no especificada');
            }

            // Mostrar la foto si está cargada
            if ($('#previewImage').attr('src')) {
                $('#previewPhoto').attr('src', $('#previewImage').attr('src'));
            }

            // Mostrar modal
            $('#modalVistaPrevia').modal('show');
        });

        // Cancelar formulario
        $('#btnCancelar').on('click', function() {
            if (confirm('¿Está seguro de que desea cancelar? Se perderán los datos no guardados.')) {
                window.location.href = '<?= base_url('postulantes') ?>';
            }
        });

        // Función para agregar campos de teléfono o email dinámicamente
        function agregarCampoContacto(tipo) {
            const container = tipo === 'telefono' ? '#telefonos-container' : '#emails-container';
            const contador = $(container).children().length + 1;

            const nuevoCampo = `
                <div class="input-group mb-2 contacto-item">
                    <input type="${tipo === 'telefono' ? 'tel' : 'email'}" 
                           class="form-control" 
                           name="${tipo}s[]" 
                           placeholder="${tipo === 'telefono' ? 'Ej: 3624-123456' : 'Ej: ejemplo@dominio.com'}">
                    <button type="button" class="btn btn-outline-danger btn-eliminar-contacto">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;

            $(container).append(nuevoCampo);
        }

        // Función para validar campos de contacto duplicados
        function validarContactosDuplicados(tipo) {
            const container = tipo === 'telefono' ? '#telefonos-container' : '#emails-container';
            const valores = [];
            let valido = true;

            $(`${container} input`).each(function() {
                const valor = $(this).val().trim();
                if (valor) {
                    if (valores.includes(valor)) {
                        $(this).addClass('is-invalid');
                        valido = false;
                    } else {
                        $(this).removeClass('is-invalid');
                        valores.push(valor);
                    }
                }
            });

            return valido;
        }

        // Event listeners para agregar teléfonos y emails
        $(document).on('click', '.btn-agregar-telefono, .btn-agregar-email', function() {
            const tipo = $(this).data('type');
            agregarCampoContacto(tipo);

            // Convertir el botón actual en botón de eliminar
            $(this).removeClass('btn-outline-success btn-agregar-telefono btn-agregar-email')
                .addClass('btn-outline-danger btn-eliminar-contacto')
                .html('<i class="fas fa-times"></i>');
        });

        // Event listener para eliminar campos de contacto
        $(document).on('click', '.btn-eliminar-contacto', function() {
            $(this).closest('.contacto-item').remove();

            // Validar que al menos quede un campo de cada tipo
            validarMinimoContactos();
        });

        // Función para validar que haya al menos un teléfono y un email
        function validarMinimoContactos() {
            const telefonos = $('#telefonos-container input').filter(function() {
                return $(this).val().trim() !== '';
            }).length;

            const emails = $('#emails-container input').filter(function() {
                return $(this).val().trim() !== '';
            }).length;

            // Actualizar requerimiento del primer campo
            $('#telefonos-container input:first').prop('required', telefonos === 0);
            $('#emails-container input:first').prop('required', emails === 0);
        }

        // Validar duplicados en tiempo real
        $(document).on('blur', '#telefonos-container input, #emails-container input', function() {
            const tipo = $(this).attr('name').includes('telefono') ? 'telefono' : 'email';
            validarContactosDuplicados(tipo);
            validarMinimoContactos();
        });

        // Validar formato de email
        $(document).on('blur', 'input[type="email"]', function() {
            const email = $(this).val().trim();
            if (email && !isValidEmail(email)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        // Función para validar formato de email
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Validar formato de teléfono (básico)
        $(document).on('blur', 'input[type="tel"]', function() {
            const telefono = $(this).val().trim();
            if (telefono && !isValidPhone(telefono)) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        });

        function isValidPhone(phone) {
            // Permite números, espacios, guiones y paréntesis
            const phoneRegex = /^[\d\s\-\+\(\)]{6,20}$/;
            return phoneRegex.test(phone.replace(/\s/g, ''));
        }

        // Inicializar si hay valores antiguos para sanciones o información sumaria
        if ($('#d_sanciones').val()) {
            $('#sanciones_descripcion_container').show();
        }

        if ($('#d_informacion_sumaria').val()) {
            $('#informacion_sumaria_descripcion_container').show();
        }
    });
</script>
<?php $this->endSection() ?>