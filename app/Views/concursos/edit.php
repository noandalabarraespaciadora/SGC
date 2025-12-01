<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">✏️ Editar Concurso</h2>
        <p class="az-dashboard-text">Modifique los datos del concurso</p>
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

        <form method="post" action="<?= base_url("concursos/actualizar/{$concurso['id']}") ?>">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Número de Expediente <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="numero_expediente"
                        value="<?= old('numero_expediente', $concurso['numero_expediente']) ?>" required maxlength="50">
                    <div class="form-text">Máximo 50 caracteres. Debe ser único en el sistema.</div>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Estado del Concurso</label>
                    <select class="form-select" name="id_estado_concurso">
                        <option value="">Seleccionar estado...</option>
                        <?php foreach ($estados as $estado): ?>
                            <option value="<?= $estado['id'] ?>"
                                <?= (old('id_estado_concurso', $concurso['id_estado_concurso']) == $estado['id']) ? 'selected' : '' ?>>
                                <?= esc($estado['denominacion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Carátula <span class="text-danger">*</span></label>
                <textarea class="form-control" name="caratula" rows="3" required><?= old('caratula', $concurso['caratula']) ?></textarea>
                <div class="form-text">Descripción detallada del concurso.</div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Resolución del STJ</label>
                    <input type="text" class="form-control" name="resolucionSTJ"
                        value="<?= old('resolucionSTJ', $concurso['resolucionSTJ']) ?>" maxlength="100">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Comunicación al CM</label>
                    <input type="text" class="form-control" name="comunicacionCM"
                        value="<?= old('comunicacionCM', $concurso['comunicacionCM']) ?>" maxlength="100">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha del Edicto</label>
                    <input type="date" class="form-control" name="fecha_edicto_publicacion"
                        value="<?= old('fecha_edicto_publicacion', $concurso['fecha_edicto_publicacion']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Examen Escrito</label>
                    <input type="datetime-local" class="form-control" name="fecha_escrito"
                        value="<?= old('fecha_escrito', $concurso['fecha_escrito']) ?>">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Examen Oral</label>
                    <input type="datetime-local" class="form-control" name="fecha_oral"
                        value="<?= old('fecha_oral', $concurso['fecha_oral']) ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Concurso Unificado</label>
                    <select class="form-select" name="id_unificado">
                        <option value="">No unificado</option>
                        <?php foreach ($unificados as $unificado): ?>
                            <option value="<?= $unificado['id'] ?>"
                                <?= (old('id_unificado', $concurso['id_unificado']) == $unificado['id']) ? 'selected' : '' ?>>
                                <?= esc($unificado['denominacion']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Propuestas - N° Oficio</label>
                    <input type="text" class="form-control" name="propuestas_nro_oficio"
                        value="<?= old('propuestas_nro_oficio', $concurso['propuestas_nro_oficio']) ?>" maxlength="100">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Fecha de Propuestas</label>
                    <input type="date" class="form-control" name="propuestas_fecha"
                        value="<?= old('propuestas_fecha', $concurso['propuestas_fecha']) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Resultado de Votación</label>
                    <input type="text" class="form-control" name="resultadoVotacion"
                        value="<?= old('resultadoVotacion', $concurso['resultadoVotacion']) ?>" maxlength="255">
                </div>
            </div>

            <!-- Comisión Examinadora -->
            <div class="mb-3">
                <label class="form-label">Comisión Examinadora</label>
                <div id="comisionContainer">
                    <?php if (!empty($concurso['comision'])): ?>
                        <?php foreach ($concurso['comision'] as $index => $miembro): ?>
                            <div class="card mb-2">
                                <div class="card-body py-2">
                                    <div class="row align-items-center">
                                        <div class="col-md-4">
                                            <select class="form-select" name="comision[<?= $index ?>][id_docente]" required>
                                                <option value="">Seleccionar docente...</option>
                                                <?php foreach ($docentes as $docente): ?>
                                                    <option value="<?= $docente['id'] ?>"
                                                        <?= ($miembro['id_docente'] == $docente['id']) ? 'selected' : '' ?>>
                                                        <?= esc($docente['apellido_y_nombre']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="comision[<?= $index ?>][id_representacion]">
                                                <option value="">Representación...</option>
                                                <?php foreach ($representaciones as $representacion): ?>
                                                    <option value="<?= $representacion['id'] ?>"
                                                        <?= ($miembro['id_representacion'] == $representacion['id']) ? 'selected' : '' ?>>
                                                        <?= esc($representacion['representacion']) ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select" name="comision[<?= $index ?>][condicion]">
                                                <option value="titular" <?= ($miembro['condicion'] == 'titular') ? 'selected' : '' ?>>Titular</option>
                                                <option value="suplente" <?= ($miembro['condicion'] == 'suplente') ? 'selected' : '' ?>>Suplente</option>
                                                <option value="renuncio" <?= ($miembro['condicion'] == 'renuncio') ? 'selected' : '' ?>>Renunció</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerMiembroComision(this)">
                                                <i class="fas fa-times"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="card mb-2">
                            <div class="card-body py-2">
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <select class="form-select" name="comision[0][id_docente]" required>
                                            <option value="">Seleccionar docente...</option>
                                            <?php foreach ($docentes as $docente): ?>
                                                <option value="<?= $docente['id'] ?>"><?= esc($docente['apellido_y_nombre']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="comision[0][id_representacion]">
                                            <option value="">Representación...</option>
                                            <?php foreach ($representaciones as $representacion): ?>
                                                <option value="<?= $representacion['id'] ?>"><?= esc($representacion['representacion']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select" name="comision[0][condicion]">
                                            <option value="titular">Titular</option>
                                            <option value="suplente">Suplente</option>
                                            <option value="renuncio">Renunció</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerMiembroComision(this)">
                                            <i class="fas fa-times"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="agregarMiembroComision()">
                    <i class="fas fa-plus me-1"></i> Agregar Miembro
                </button>
                <div class="form-text">Puede editar, eliminar o agregar nuevos miembros de la comisión.</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="2"><?= old('observaciones', $concurso['observaciones']) ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save"></i> Guardar cambios
            </button>
            <a href="<?= base_url('concursos') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancelar
            </a>
        </form>
    </div>
</div>

<script>
    let contadorComision = <?= !empty($concurso['comision']) ? count($concurso['comision']) : 1 ?>;

    function agregarMiembroComision() {
        const html = `
            <div class="card mb-2">
                <div class="card-body py-2">
                    <div class="row align-items-center">
                        <div class="col-md-4">
                            <select class="form-select" name="comision[${contadorComision}][id_docente]" required>
                                <option value="">Seleccionar docente...</option>
                                <?php foreach ($docentes as $docente): ?>
                                    <option value="<?= $docente['id'] ?>"><?= esc($docente['apellido_y_nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="comision[${contadorComision}][id_representacion]">
                                <option value="">Representación...</option>
                                <?php foreach ($representaciones as $representacion): ?>
                                    <option value="<?= $representacion['id'] ?>"><?= esc($representacion['representacion']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" name="comision[${contadorComision}][condicion]">
                                <option value="titular">Titular</option>
                                <option value="suplente">Suplente</option>
                                <option value="renuncio">Renunció</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removerMiembroComision(this)">
                                <i class="fas fa-times"></i> Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#comisionContainer').append(html);
        contadorComision++;
    }

    function removerMiembroComision(button) {
        $(button).closest('.card').remove();
    }
</script>
<?php $this->endSection() ?>