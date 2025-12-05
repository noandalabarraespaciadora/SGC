<?php
// File: app/Views/rotacion/index.php

$this->extend('layouts/main'); ?>

<?php $this->section('content'); ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">🔄 Rotación de Personal T_T</h2>
                    <p class="az-dashboard-text">Gestione la rotación del personal para el turno tarde (17-19hs)</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="view-toggle me-2">
                        <button class="view-toggle-btn <?= $view === 'semanal' ? 'active' : '' ?>"
                            onclick="cambiarVista('semanal')">
                            <i class="fas fa-calendar-week me-1"></i> Semanal
                        </button>
                        <button class="view-toggle-btn <?= $view === 'mensual' ? 'active' : '' ?>"
                            onclick="cambiarVista('mensual')">
                            <i class="fas fa-calendar-alt me-1"></i> Mensual
                        </button>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarPersonal">
                        <i class="fas fa-plus me-1"></i> Asignar Personal
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
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Vista Semanal -->
            <div class="calendar-container <?= $view !== 'semanal' ? 'd-none' : '' ?>" id="vistaSemanal">
                <div class="calendar-header">
                    <div class="calendar-nav">
                        <button class="btn btn-outline-secondary btn-sm" onclick="cambiarSemana(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h3 class="calendar-title" id="semanaTitulo">Semana Actual</h3>
                        <button class="btn btn-outline-secondary btn-sm" onclick="cambiarSemana(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" onclick="hoy()">
                        <i class="fas fa-calendar-day me-1"></i> Hoy
                    </button>
                </div>

                <div class="week-view" id="weekView">
                    <!-- Los días se cargan dinámicamente con JavaScript -->
                </div>

                <div class="legend">
                    <?php foreach ($tipos_dia as $tipo): ?>
                        <div class="legend-item">
                            <div class="legend-color" style="background: <?= $tipo['color'] ?>; border: 2px solid <?= $tipo['color'] ?>"></div>
                            <span><?= $tipo['nombre'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Vista Mensual -->
            <div class="calendar-container <?= $view !== 'mensual' ? 'd-none' : '' ?>" id="vistaMensual">
                <div class="calendar-header">
                    <div class="calendar-nav">
                        <button class="btn btn-outline-secondary btn-sm" onclick="cambiarMes(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <h3 class="calendar-title" id="mesTitulo">Mes Actual</h3>
                        <button class="btn btn-outline-secondary btn-sm" onclick="cambiarMes(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <button class="btn btn-outline-primary btn-sm" onclick="hoy()">
                        <i class="fas fa-calendar-day me-1"></i> Hoy
                    </button>
                </div>

                <div class="month-header d-flex text-center fw-bold mb-2">
                    <div class="flex-fill">Lun</div>
                    <div class="flex-fill">Mar</div>
                    <div class="flex-fill">Mié</div>
                    <div class="flex-fill">Jue</div>
                    <div class="flex-fill">Vie</div>
                    <div class="flex-fill text-muted">Sáb</div>
                    <div class="flex-fill text-muted">Dom</div>
                </div>

                <div class="month-view" id="monthView">
                    <!-- Los días del mes se cargan dinámicamente con JavaScript -->
                </div>

                <div class="legend mt-3">
                    <?php foreach ($tipos_dia as $tipo): ?>
                        <div class="legend-item">
                            <div class="legend-color" style="background: <?= $tipo['color'] ?>; border: 2px solid <?= $tipo['color'] ?>"></div>
                            <span><?= $tipo['nombre'] ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para asignar personal -->
    <div class="modal fade" id="modalAsignarPersonal" tabindex="-1" aria-labelledby="modalAsignarPersonalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAsignarPersonalLabel">Asignar Personal a Rotación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('rotacion/guardar') ?>" method="post" id="formAsignarPersonal">
                    <?= csrf_field() ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="asignarFecha" class="form-label">Fecha <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="asignarFecha" name="fecha" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="asignarTipoEvento" class="form-label">Tipo de Día</label>
                                <select class="form-control" id="asignarTipoEvento" name="tipo_dia_id">
                                    <option value="">Seleccionar tipo...</option>
                                    <?php foreach ($tipos_dia as $tipo): ?>
                                        <option value="<?= $tipo['id'] ?>" data-requiere-acuerdo="<?= $tipo['requiere_acuerdo'] ?>">
                                            <?= $tipo['nombre'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3" id="acuerdoFields" style="display: none;">
                            <label for="numeroAcuerdo" class="form-label">Número de Acuerdo</label>
                            <input type="text" class="form-control" id="numeroAcuerdo" name="numero_acuerdo" placeholder="Ej: AC-2024-001">
                        </div>

                        <div class="mb-3">
                            <label for="observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Personal a Asignar <span class="text-danger">*</span></label>
                            <div id="personalDisponible" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach ($personal as $persona): ?>
                                    <?php
                                    $avatarColor = get_avatar_color($persona['nombre'] . ' ' . $persona['apellido']);
                                    $iniciales = strtoupper(substr($persona['nombre'], 0, 1) . substr($persona['apellido'], 0, 1));
                                    ?>
                                    <div class="personal-item">
                                        <?php if ($persona['url_foto']): ?>
                                            <img src="<?= base_url($persona['url_foto']) ?>" alt="Foto" class="personal-avatar">
                                        <?php else: ?>
                                            <div class="personal-avatar d-flex align-items-center justify-content-center"
                                                style="background-color: <?= $avatarColor ?>; color: white;">
                                                <?= $iniciales ?>
                                            </div>
                                        <?php endif; ?>
                                        <div class="personal-info">
                                            <div class="personal-name"><?= $persona['nombre'] ?> <?= $persona['apellido'] ?></div>
                                            <div class="personal-type">
                                                <span class="badge <?= $persona['categoria'] === 'jerarquico' ? 'bg-primary' : 'bg-secondary' ?>">
                                                    <?= $persona['categoria'] === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico' ?>
                                                </span>
                                                <?php if ($persona['area']): ?>
                                                    <span class="ms-1">• <?= $persona['area'] ?></span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="personal_ids[]"
                                                value="<?= $persona['id'] ?>" id="checkPersona<?= $persona['id'] ?>">
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Asignación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para editar día -->
    <div class="modal fade" id="modalEditarDia" tabindex="-1" aria-labelledby="modalEditarDiaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarDiaLabel">Editar Asignaciones del Día</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?= base_url('rotacion/guardar') ?>" method="post" id="formEditarDia">
                    <?= csrf_field() ?>
                    <div class="modal-body" id="editarDiaContent">
                        <!-- Contenido dinámico -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Estilos del módulo de rotación - Copia del HTML proporcionado */
        .calendar-container {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .calendar-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .calendar-nav {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .calendar-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
            min-width: 200px;
            text-align: center;
        }

        .week-view {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 1rem;
        }

        .day-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 1rem;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .day-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .day-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #dee2e6;
        }

        .day-name {
            font-weight: 600;
            color: #2c3e50;
            text-transform: capitalize;
        }

        .day-date {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .day-concurso {
            border-color: #ffc107;
            background: #fffdf6;
        }

        .event-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            margin-bottom: 0.5rem;
            display: inline-block;
        }

        .badge-concurso {
            background: #ffc107;
            color: #212529;
        }

        .personal-list {
            min-height: 120px;
        }

        .personal-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem;
            margin-bottom: 0.5rem;
            background: white;
            border-radius: 8px;
            border: 1px solid #e9ecef;
        }

        .personal-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .personal-info {
            flex: 1;
        }

        .personal-name {
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
        }

        .personal-type {
            font-size: 0.75rem;
            color: #6c757d;
        }

        .personal-actions {
            display: flex;
            gap: 0.25rem;
        }

        .empty-day {
            text-align: center;
            color: #6c757d;
            padding: 2rem 1rem;
        }

        .empty-day i {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            opacity: 0.5;
        }

        .view-toggle {
            display: flex;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            overflow: hidden;
        }

        .view-toggle-btn {
            padding: 0.5rem 1rem;
            border: none;
            background: white;
            color: #6c757d;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .view-toggle-btn.active {
            background: #007bff;
            color: white;
        }

        .view-toggle-btn:not(:last-child) {
            border-right: 1px solid #dee2e6;
        }

        /* Vista Mensual */
        .month-view {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 0.5rem;
        }

        .month-day {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 0.75rem;
            min-height: 120px;
            border: 2px solid transparent;
            position: relative;
        }

        .month-day.weekend {
            background: #e9ecef;
            opacity: 0.7;
        }

        .month-day.concurso {
            border-color: #ffc107;
            background: #fffdf6;
        }

        .month-day-header {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .month-day-number {
            font-weight: 600;
            color: #2c3e50;
        }

        .month-personal {
            display: flex;
            flex-wrap: wrap;
            gap: 0.25rem;
            margin-bottom: 0.25rem;
        }

        .avatar-stack {
            display: flex;
            margin-left: -8px;
        }

        .avatar-stack .month-avatar {
            margin-left: -8px;
            border: 2px solid white;
            transition: all 0.3s ease;
        }

        .avatar-stack .month-avatar:hover {
            transform: translateY(-2px);
            z-index: 2;
        }

        .month-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .month-event-badge {
            font-size: 0.6rem;
            padding: 0.1rem 0.3rem;
            border-radius: 8px;
            margin-top: 0.25rem;
            display: inline-block;
        }

        .legend {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .legend-color {
            width: 16px;
            height: 16px;
            border-radius: 4px;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .week-view {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 767.98px) {
            .week-view {
                grid-template-columns: repeat(2, 1fr);
            }

            .calendar-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .calendar-nav {
                width: 100%;
                justify-content: space-between;
            }

            .calendar-title {
                font-size: 1.25rem;
                min-width: auto;
            }
        }

        @media (max-width: 575.98px) {
            .week-view {
                grid-template-columns: 1fr;
            }

            .month-view {
                grid-template-columns: repeat(7, 1fr);
                font-size: 0.75rem;
            }

            .month-day {
                min-height: 80px;
                padding: 0.5rem;
            }
        }

        .border-primary {
            border-color: #007bff !important;
        }

        .border-success {
            border-color: #28a745 !important;
        }

        .border-warning {
            border-color: #ffc107 !important;
        }

        .border-info {
            border-color: #17a2b8 !important;
        }

        .border-danger {
            border-color: #dc3545 !important;
        }

        .border-secondary {
            border-color: #6c757d !important;
        }
    </style>

    <?php $this->endSection(); ?>

    <?php $this->section('scripts'); ?>
    <script>
        // Variables globales
        let fechaActual = '<?= $fecha_actual ?>';
        let vistaActual = '<?= $view ?>';
        let rotaciones = <?= json_encode($rotaciones) ?>;
        let personal = <?= json_encode($personal) ?>;
        let tiposDia = <?= json_encode($tipos_dia) ?>;

        // Inicializar
        $(document).ready(function() {
            // Formatear personal con color de avatar
            personal.forEach(persona => {
                if (!persona.color_avatar) {
                    persona.color_avatar = generarColorAvatar(persona.nombre + ' ' + persona.apellido);
                }
            });

            // Renderizar vista inicial
            if (vistaActual === 'semanal') {
                renderVistaSemanal();
            } else {
                renderVistaMensual();
            }

            // Control de tipo de evento en modal
            $('#asignarTipoEvento').on('change', function() {
                const selected = $(this).find('option:selected');
                const requiereAcuerdo = selected.data('requiere-acuerdo');

                if (requiereAcuerdo == 1) {
                    $('#acuerdoFields').show();
                    $('#numeroAcuerdo').prop('required', true);
                } else {
                    $('#acuerdoFields').hide();
                    $('#numeroAcuerdo').prop('required', false);
                }
            });

            // Prevenir fin de semana en fecha
            $('#asignarFecha').on('change', function() {
                const fecha = new Date(this.value);
                const diaSemana = fecha.getDay();

                if (diaSemana === 0 || diaSemana === 6) {
                    alert('No se pueden asignar rotaciones para fines de semana');
                    this.value = '';
                }
            });

            // Cargar datos al abrir modal para editar
            $('#modalAsignarPersonal').on('show.bs.modal', function() {
                $('#formAsignarPersonal')[0].reset();
                $('#acuerdoFields').hide();
                $('#numeroAcuerdo').prop('required', false);

                // Establecer fecha actual si no hay fecha seleccionada
                if (!$('#asignarFecha').val()) {
                    const hoy = new Date();
                    // Si es fin de semana, ir al próximo lunes
                    if (hoy.getDay() === 0) {
                        hoy.setDate(hoy.getDate() + 1);
                    } else if (hoy.getDay() === 6) {
                        hoy.setDate(hoy.getDate() + 2);
                    }
                    $('#asignarFecha').val(hoy.toISOString().split('T')[0]);
                }
            });
        });

        // Funciones de navegación
        function cambiarVista(vista) {
            vistaActual = vista;
            window.location.href = `<?= base_url('rotacion') ?>?view=${vista}&fecha=${fechaActual}`;
        }

        function cambiarSemana(direccion) {
            const fecha = new Date(fechaActual);
            fecha.setDate(fecha.getDate() + (direccion * 7));
            fechaActual = fecha.toISOString().split('T')[0];
            window.location.href = `<?= base_url('rotacion') ?>?view=semanal&fecha=${fechaActual}`;
        }

        function cambiarMes(direccion) {
            const fecha = new Date(fechaActual);
            fecha.setMonth(fecha.getMonth() + direccion);
            fechaActual = fecha.toISOString().split('T')[0];
            window.location.href = `<?= base_url('rotacion') ?>?view=mensual&fecha=${fechaActual}`;
        }

        function hoy() {
            const hoy = new Date();
            fechaActual = hoy.toISOString().split('T')[0];
            window.location.href = `<?= base_url('rotacion') ?>?view=${vistaActual}&fecha=${fechaActual}`;
        }

        // Funciones de renderizado
        function renderVistaSemanal() {
            const semanaTitulo = $('#semanaTitulo');
            const weekView = $('#weekView');
            weekView.empty();

            // Calcular inicio de semana (lunes)
            const inicioSemana = new Date(fechaActual);
            const diaActual = inicioSemana.getDay();
            const diferencia = diaActual === 0 ? -6 : 1 - diaActual;
            inicioSemana.setDate(inicioSemana.getDate() + diferencia);

            // Actualizar título
            const finSemana = new Date(inicioSemana);
            finSemana.setDate(inicioSemana.getDate() + 4);

            const opciones = {
                month: 'long',
                year: 'numeric'
            };
            let titulo = `Semana ${inicioSemana.getDate()}-${finSemana.getDate()} `;

            if (inicioSemana.getMonth() === finSemana.getMonth()) {
                titulo += inicioSemana.toLocaleDateString('es-ES', {
                    month: 'long'
                });
            } else {
                titulo += inicioSemana.toLocaleDateString('es-ES', {
                        month: 'short'
                    }) + ' - ' +
                    finSemana.toLocaleDateString('es-ES', {
                        month: 'short'
                    });
            }

            titulo += ` ${inicioSemana.getFullYear()}`;
            semanaTitulo.text(titulo);

            // Generar días de la semana (lunes a viernes)
            for (let i = 0; i < 5; i++) {
                const dia = new Date(inicioSemana);
                dia.setDate(inicioSemana.getDate() + i);
                const diaHtml = generarDiaSemanal(dia);
                weekView.append(diaHtml);
            }
        }

        function generarDiaSemanal(fecha) {
            const fechaStr = fecha.toISOString().split('T')[0];
            const rotacion = rotaciones.find(r => r.fecha === fechaStr);
            const esHoy = esMismaFecha(fecha, new Date());

            let diaClase = 'day-card';
            let estiloBorde = '';
            let eventoHtml = '';
            let personalHtml = '';

            if (rotacion) {
                const tipoDia = tiposDia.find(t => t.id == rotacion.tipo_dia_id);
                if (tipoDia) {
                    estiloBorde = `border-color: ${tipoDia.color}; background: ${tipoDia.color}10;`;

                    eventoHtml = `<div class="event-badge" style="background: ${tipoDia.color}; color: ${getContrastColor(tipoDia.color)}">
                    ${tipoDia.nombre}
                    ${rotacion.numero_acuerdo ? ' - ' + rotacion.numero_acuerdo : ''}
                </div>`;
                }

                // Lista de personal asignado
                if (rotacion.personal && rotacion.personal.length > 0) {
                    rotacion.personal.forEach(persona => {
                        personalHtml += generarItemPersonal(persona, fechaStr, true);
                    });
                } else {
                    personalHtml = `<div class="empty-day">
                    <i class="fas fa-users"></i>
                    <div>Sin personal asignado</div>
                </div>`;
                }
            } else {
                personalHtml = `<div class="empty-day">
                <i class="fas fa-calendar-plus"></i>
                <div>Sin asignaciones</div>
            </div>`;
            }

            return `
            <div class="${diaClase}" data-fecha="${fechaStr}" style="${estiloBorde}">
                <div class="day-header">
                    <div class="day-name">${fecha.toLocaleDateString('es-ES', { weekday: 'long' })}</div>
                    <div class="day-date ${esHoy ? 'text-primary fw-bold' : ''}">${fecha.getDate()}</div>
                </div>
                ${eventoHtml}
                ${rotacion && rotacion.observaciones ? `<div class="small text-muted mb-2">${rotacion.observaciones}</div>` : ''}
                <div class="personal-list">
                    ${personalHtml}
                </div>
                <div class="text-end mt-2">
                    <button class="btn btn-sm btn-outline-primary" onclick="editarDia('${fechaStr}')">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                </div>
            </div>
        `;
        }

        function generarItemPersonal(persona, fecha, mostrarEliminar = false) {
            const iniciales = (persona.nombre?.charAt(0) || '') + (persona.apellido?.charAt(0) || '');
            const avatarColor = persona.color_avatar || generarColorAvatar(persona.nombre + ' ' + persona.apellido);

            const avatarHtml = persona.url_foto ?
                `<img src="<?= base_url() ?>${persona.url_foto}" alt="Foto" class="personal-avatar">` :
                `<div class="personal-avatar d-flex align-items-center justify-content-center" style="background-color: ${avatarColor}; color: white;">
                ${iniciales}
              </div>`;

            const acciones = mostrarEliminar ?
                `<div class="personal-actions">
                  <button class="btn btn-sm btn-outline-danger" onclick="eliminarPersonalDelModal('${fecha}', ${persona.id})">
                      <i class="fas fa-times"></i>
                  </button>
               </div>` :
                '';

            return `
            <div class="personal-item">
                ${avatarHtml}
                <div class="personal-info">
                    <div class="personal-name">${persona.nombre} ${persona.apellido}</div>
                    <div class="personal-type">
                        <span class="badge ${persona.categoria === 'jerarquico' ? 'bg-primary' : 'bg-secondary'}">
                            ${persona.categoria === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico'}
                        </span>
                        ${persona.area ? `<span class="ms-1">• ${persona.area}</span>` : ''}
                    </div>
                </div>
                ${acciones}
            </div>
        `;
        }

        function renderVistaMensual() {
            const mesTitulo = $('#mesTitulo');
            const monthView = $('#monthView');
            monthView.empty();

            const fecha = new Date(fechaActual);
            const mes = fecha.toLocaleDateString('es-ES', {
                month: 'long',
                year: 'numeric'
            });
            mesTitulo.text(mes.charAt(0).toUpperCase() + mes.slice(1));

            // Calcular primer día del mes
            const primerDia = new Date(fecha.getFullYear(), fecha.getMonth(), 1);

            // Ajustar para que empiece en lunes
            let diaInicio = new Date(primerDia);
            const diaSemana = diaInicio.getDay();
            const ajuste = diaSemana === 0 ? -6 : 1 - diaSemana;
            diaInicio.setDate(primerDia.getDate() + ajuste);

            // Generar días del mes (6 semanas)
            for (let i = 0; i < 42; i++) {
                const dia = new Date(diaInicio);
                dia.setDate(diaInicio.getDate() + i);
                const diaHtml = generarDiaMensual(dia);
                monthView.append(diaHtml);
            }
        }

        function generarDiaMensual(fecha) {
            const fechaStr = fecha.toISOString().split('T')[0];
            const rotacion = rotaciones.find(r => r.fecha === fechaStr);
            const esMesActual = fecha.getMonth() === new Date(fechaActual).getMonth();
            const esFinSemana = fecha.getDay() === 0 || fecha.getDay() === 6;
            const esHoy = esMismaFecha(fecha, new Date());

            let claseDia = 'month-day';
            let estilo = '';

            if (!esMesActual) {
                claseDia += ' text-muted opacity-50';
            }

            if (esFinSemana) {
                claseDia += ' weekend';
            }

            if (rotacion) {
                const tipoDia = tiposDia.find(t => t.id == rotacion.tipo_dia_id);
                if (tipoDia) {
                    estilo = `border-color: ${tipoDia.color}; background: ${tipoDia.color}10;`;
                }
            }

            let personalHtml = '';
            let eventoHtml = '';

            if (rotacion && rotacion.personal && rotacion.personal.length > 0) {
                // Mostrar avatares apilados
                personalHtml = `<div class="avatar-stack">`;
                rotacion.personal.slice(0, 3).forEach(persona => {
                    const iniciales = (persona.nombre?.charAt(0) || '') + (persona.apellido?.charAt(0) || '');
                    const avatarColor = persona.color_avatar || generarColorAvatar(persona.nombre + ' ' + persona.apellido);

                    if (persona.url_foto) {
                        personalHtml += `<img src="<?= base_url() ?>${persona.url_foto}" alt="${persona.nombre}" class="month-avatar" 
                        title="${persona.nombre} ${persona.apellido} - ${persona.categoria === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico'}">`;
                    } else {
                        personalHtml += `<div class="month-avatar d-flex align-items-center justify-content-center" 
                        style="background-color: ${avatarColor}; color: white; font-size: 0.6rem;" 
                        title="${persona.nombre} ${persona.apellido} - ${persona.categoria === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico'}">
                        ${iniciales}
                    </div>`;
                    }
                });
                personalHtml += `</div>`;

                // Contador si hay más de 3
                if (rotacion.personal.length > 3) {
                    personalHtml += `<small class="text-muted">+${rotacion.personal.length - 3} más</small>`;
                }

                // Badge de evento
                if (rotacion.tipo_dia_id) {
                    const tipoDia = tiposDia.find(t => t.id == rotacion.tipo_dia_id);
                    if (tipoDia) {
                        eventoHtml = `<div class="month-event-badge" style="background: ${tipoDia.color}; color: ${getContrastColor(tipoDia.color)}">
                        ${tipoDia.nombre.substring(0, 10)}${tipoDia.nombre.length > 10 ? '...' : ''}
                    </div>`;
                    }
                }
            }

            return `
            <div class="${claseDia}" data-fecha="${fechaStr}" onclick="editarDia('${fechaStr}')" 
                 style="${estilo}" title="${fecha.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}">
                <div class="month-day-header">
                    <div class="month-day-number ${esHoy ? 'text-primary fw-bold' : ''}">${fecha.getDate()}</div>
                </div>
                <div class="month-personal">
                    ${personalHtml || '<i class="fas fa-user-clock text-muted"></i>'}
                </div>
                ${eventoHtml}
            </div>
        `;
        }

        // Funciones auxiliares
        function esMismaFecha(fecha1, fecha2) {
            return fecha1.getDate() === fecha2.getDate() &&
                fecha1.getMonth() === fecha2.getMonth() &&
                fecha1.getFullYear() === fecha2.getFullYear();
        }

        function generarColorAvatar(texto) {
            const colores = [
                '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
                '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9',
                '#F8C471', '#82E0AA'
            ];
            const hash = texto.split('').reduce((acc, char) => char.charCodeAt(0) + acc, 0);
            return colores[hash % colores.length];
        }

        function getContrastColor(hexColor) {
            // Convertir hex a RGB
            const r = parseInt(hexColor.substr(1, 2), 16);
            const g = parseInt(hexColor.substr(3, 2), 16);
            const b = parseInt(hexColor.substr(5, 2), 16);

            // Calcular luminosidad
            const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;
            return luminance > 0.5 ? '#000000' : '#FFFFFF';
        }

        // Funciones de edición
        async function editarDia(fecha) {
            try {
                const response = await fetch(`<?= base_url('rotacion/api/rotacion/') ?>${fecha}`);
                const result = await response.json();

                if (result.success) {
                    const rotacion = result.data;
                    const fechaObj = new Date(fecha);

                    let contenido = `
                    <input type="hidden" name="fecha" value="${fecha}">
                    <h6>${fechaObj.toLocaleDateString('es-ES', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })}</h6>
                    
                    <div class="mb-3">
                        <label class="form-label">Tipo de Día</label>
                        <select class="form-control" name="tipo_dia_id" id="editarTipoEvento">
                            <option value="">Seleccionar tipo...</option>
                `;

                    tiposDia.forEach(tipo => {
                        const selected = rotacion && rotacion.tipo_dia_id == tipo.id ? 'selected' : '';
                        contenido += `<option value="${tipo.id}" ${selected} data-requiere-acuerdo="${tipo.requiere_acuerdo}">${tipo.nombre}</option>`;
                    });

                    contenido += `
                        </select>
                    </div>

                    <div class="mb-3" id="editarAcuerdoFields" style="${rotacion && rotacion.tipo_dia_id && tiposDia.find(t => t.id == rotacion.tipo_dia_id)?.requiere_acuerdo ? '' : 'display: none;'}">
                        <label for="editarNumeroAcuerdo" class="form-label">Número de Acuerdo</label>
                        <input type="text" class="form-control" name="numero_acuerdo" value="${rotacion?.numero_acuerdo || ''}" placeholder="Ej: AC-2024-001">
                    </div>

                    <div class="mb-3">
                        <label for="editarObservaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" name="observaciones" rows="2">${rotacion?.observaciones || ''}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Personal Asignado</label>
                        <div id="editarPersonalList" style="max-height: 200px; overflow-y: auto;">
                `;

                    // Personal ya asignado
                    if (rotacion && rotacion.personal) {
                        rotacion.personal.forEach(persona => {
                            contenido += generarItemPersonal(persona, fecha, true);
                        });
                    }

                    contenido += `
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Agregar Personal</label>
                        <select class="form-control" id="agregarPersonalSelect">
                            <option value="">Seleccionar personal...</option>
                `;

                    // Personal disponible
                    const personalAsignadoIds = rotacion?.personal ? rotacion.personal.map(p => p.id) : [];
                    personal.forEach(persona => {
                        if (!personalAsignadoIds.includes(persona.id)) {
                            contenido += `<option value="${persona.id}">${persona.nombre} ${persona.apellido} - ${persona.categoria === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico'}</option>`;
                        }
                    });

                    contenido += `
                        </select>
                        <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="agregarPersonalDia('${fecha}')">
                            <i class="fas fa-plus me-1"></i> Agregar
                        </button>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i> Los cambios se guardarán al presionar "Guardar Cambios"
                    </div>
                `;

                    $('#editarDiaContent').html(contenido);

                    // Control de cambio de tipo de evento
                    $('#editarTipoEvento').off('change').on('change', function() {
                        const selected = $(this).find('option:selected');
                        if (selected.data('requiere-acuerdo') == 1) {
                            $('#editarAcuerdoFields').show();
                        } else {
                            $('#editarAcuerdoFields').hide();
                        }
                    });

                    const modal = new bootstrap.Modal(document.getElementById('modalEditarDia'));
                    modal.show();
                }
            } catch (error) {
                console.error('Error al cargar datos del día:', error);
                alert('Error al cargar los datos del día');
            }
        }

        function agregarPersonalDia(fecha) {
            const select = document.getElementById('agregarPersonalSelect');
            const personaId = parseInt(select.value);

            if (!personaId) {
                alert('Seleccione una persona para agregar');
                return;
            }

            const persona = personal.find(p => p.id === personaId);
            if (!persona) return;

            // Agregar al HTML
            const personaHtml = generarItemPersonal(persona, fecha, true);
            $('#editarPersonalList').append(personaHtml);

            // Agregar checkbox oculto al formulario
            $('#formEditarDia').append(`<input type="hidden" name="personal_ids[]" value="${personaId}">`);

            // Resetear select
            select.value = '';

            // Remover del select de opciones
            $(select).find(`option[value="${personaId}"]`).remove();
        }

        function eliminarPersonalDelModal(fecha, personaId) {
            // Buscar el item en el listado y eliminarlo
            $(`.personal-item:has(button[onclick*="${personaId}"])`).remove();

            // Remover el input hidden correspondiente
            $(`#formEditarDia input[name="personal_ids[]"][value="${personaId}"]`).remove();

            // Agregar de nuevo al select de opciones
            const persona = personal.find(p => p.id === personaId);
            if (persona) {
                const option = `<option value="${persona.id}">${persona.nombre} ${persona.apellido} - ${persona.categoria === 'jerarquico' ? 'Jerárquico' : 'No Jerárquico'}</option>`;
                $('#agregarPersonalSelect').append(option);
            }
        }

        // Confirmar eliminación
        function confirmarEliminar(fecha) {
            if (confirm('¿Está seguro de eliminar la rotación de esta fecha? Esta acción no se puede deshacer.')) {
                window.location.href = `<?= base_url('rotacion/eliminar/') ?>${fecha}`;
            }
        }
    </script>
    <?php $this->endSection(); ?>