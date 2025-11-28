<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">📅 Calendario de Actividades</h2>
        <p class="az-dashboard-text">Vista mensual, semanal y diaria de las actividades programadas</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <!-- Controles del calendario -->
        <div class="calendar-controls">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-outline-secondary btn-sm" id="prevBtn">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h5 class="mb-0" id="currentMonth"><?= date('F Y', strtotime($currentDate)) ?></h5>
                <button class="btn btn-outline-secondary btn-sm" id="nextBtn">
                    <i class="fas fa-chevron-right"></i>
                </button>
                <button class="btn btn-outline-primary btn-sm" id="todayBtn">
                    <i class="fas fa-calendar-day me-1"></i> Hoy
                </button>
            </div>

            <ul class="nav view-tabs" id="viewTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $currentView === 'month' ? 'active' : '' ?>" id="month-tab" data-bs-toggle="tab" data-bs-target="#month" type="button" role="tab">
                        Mensual
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $currentView === 'week' ? 'active' : '' ?>" id="week-tab" data-bs-toggle="tab" data-bs-target="#week" type="button" role="tab">
                        Semanal
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link <?= $currentView === 'day' ? 'active' : '' ?>" id="day-tab" data-bs-toggle="tab" data-bs-target="#day" type="button" role="tab">
                        Diario
                    </button>
                </li>
            </ul>
        </div>

        <!-- Vista del Calendario -->
        <div class="calendar-view">
            <div class="tab-content" id="calendarViews">
                <!-- Vista Mensual -->
                <div class="tab-pane fade <?= $currentView === 'month' ? 'show active' : '' ?>" id="month" role="tabpanel">
                    <div class="calendar-grid" id="monthCalendar">
                        <!-- Se genera dinámicamente -->
                    </div>
                </div>

                <!-- Vista Semanal -->
                <div class="tab-pane fade <?= $currentView === 'week' ? 'show active' : '' ?>" id="week" role="tabpanel">
                    <div class="calendar-grid" id="weekCalendar">
                        <!-- Se genera dinámicamente -->
                    </div>
                </div>

                <!-- Vista Diaria -->
                <div class="tab-pane fade <?= $currentView === 'day' ? 'show active' : '' ?>" id="day" role="tabpanel">
                    <div class="day-view-container" id="dayCalendar">
                        <!-- Se genera dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Botones de acción -->
<div class="mt-3 d-flex justify-content-between">
    <a href="<?= base_url('actividades') ?>" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-1"></i> Volver al listado
    </a>
    <div class="d-flex gap-2">
        <a href="<?= base_url('actividades/lista') ?>" class="btn btn-outline-primary">
            <i class="fas fa-list me-1"></i> Vista de Lista
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaActividad">
            <i class="fas fa-plus me-1"></i> Nueva Actividad
        </button>
    </div>
</div>

<!-- Modal para ver detalles de la actividad -->
<div class="modal fade" id="modalActividadDetalle" tabindex="-1" aria-labelledby="modalActividadDetalleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header event-modal-header">
                <h5 class="modal-title" id="modalActividadDetalleLabel">Detalles de la Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h4 id="actividadTitle">Título de la Actividad</h4>
                    <span class="event-type-badge badge" id="actividadTypeBadge">Tipo</span>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Fecha y Hora</div>
                        <div class="event-detail-value" id="actividadFechaHora">Fecha y hora</div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Duración</div>
                        <div class="event-detail-value" id="actividadDuracion">Duración</div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Sede</div>
                        <div class="event-detail-value" id="actividadSede">Sede</div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-laptop-house"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Modalidad</div>
                        <div class="event-detail-value" id="actividadModalidad">Modalidad</div>
                    </div>
                </div>

                <div class="event-detail-item">
                    <div class="event-detail-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="event-detail-content">
                        <div class="event-detail-label">Descripción</div>
                        <div class="event-detail-value" id="actividadDescripcion">Descripción</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="#" class="btn btn-primary" id="btnEditarActividad">
                    <i class="fas fa-edit me-1"></i> Editar Actividad
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Modal para nueva actividad -->
<div class="modal fade" id="modalNuevaActividad" tabindex="-1" aria-labelledby="modalNuevaActividadLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalNuevaActividadLabel">Crear Nueva Actividad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formNuevaActividad" action="<?= base_url('actividades/crear') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="actividadTitulo" class="form-label">Título de la Actividad <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="actividadTitulo" name="titulo" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="actividadFecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="actividadFecha" name="fecha">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="actividadHora" class="form-label">Hora</label>
                            <input type="time" class="form-control" id="actividadHora" name="hora">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="actividadDuracion" class="form-label">Duración (minutos)</label>
                        <input type="number" class="form-control" id="actividadDuracion" name="duracion" min="1" placeholder="Ej: 60">
                    </div>

                    <div class="mb-3">
                        <label for="actividadTipo" class="form-label">Tipo de Actividad</label>
                        <select class="form-control" id="actividadTipo" name="id_tipo_actividad">
                            <option value="">Seleccione tipo</option>
                            <?php foreach ($tiposActividad as $tipo): ?>
                                <option value="<?= $tipo['id'] ?>"><?= esc($tipo['actividad']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="actividadSede" class="form-label">Sede</label>
                        <select class="form-control" id="actividadSede" name="id_sede">
                            <option value="">Seleccione sede</option>
                            <?php foreach ($sedes as $sede): ?>
                                <option value="<?= $sede['id'] ?>"><?= esc($sede['denominacion']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="actividadModalidad" class="form-label">Modalidad</label>
                        <select class="form-control" id="actividadModalidad" name="id_modalidad">
                            <option value="">Seleccione modalidad</option>
                            <?php foreach ($modalidades as $modalidad): ?>
                                <option value="<?= $modalidad['id'] ?>"><?= esc($modalidad['modalidad']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="actividadDescripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="actividadDescripcion" name="descripcion" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="formNuevaActividad" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Guardar Actividad
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .calendar-view {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .calendar-controls {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }

    .view-tabs .nav-link {
        border: none;
        color: #6c757d;
        padding: 0.5rem 1rem;
        font-weight: 500;
    }

    .view-tabs .nav-link.active {
        color: #007bff;
        background: transparent;
        border-bottom: 2px solid #007bff;
    }

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 1px;
        background: #dee2e6;
    }

    .calendar-day {
        background: white;
        min-height: 120px;
        padding: 0.5rem;
        position: relative;
    }

    .calendar-day.header {
        background: #f8f9fa;
        font-weight: 600;
        text-align: center;
        padding: 1rem 0.5rem;
        min-height: auto;
    }

    .calendar-day.other-month {
        background: #f8f9fa;
        color: #6c757d;
    }

    .calendar-day.today {
        background: #e7f3ff;
    }

    .day-number {
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .event-item {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        margin-bottom: 0.25rem;
        border-radius: 4px;
        cursor: pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-more {
        font-size: 0.75rem;
        color: #6c757d;
        cursor: pointer;
    }

    .day-view-container {
        display: flex;
        height: 600px;
        overflow-y: auto;
    }

    .time-slots {
        width: 80px;
        background: #f8f9fa;
        border-right: 1px solid #dee2e6;
    }

    .time-slot {
        height: 60px;
        display: flex;
        align-items: flex-start;
        justify-content: flex-end;
        padding: 0.5rem;
        font-size: 0.875rem;
        color: #6c757d;
        border-bottom: 1px solid #dee2e6;
    }

    .day-events {
        flex: 1;
        position: relative;
        background: white;
    }

    .day-event {
        position: absolute;
        left: 10px;
        right: 10px;
        padding: 0.5rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.875rem;
        overflow: hidden;
        border-left: 4px solid;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .event-time {
        font-weight: 600;
        font-size: 0.75rem;
        margin-bottom: 0.25rem;
    }

    .event-title {
        font-weight: 500;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .event-meta {
        font-size: 0.7rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }

    .event-modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    .event-type-badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    .event-detail-item {
        display: flex;
        margin-bottom: 1rem;
        align-items: flex-start;
    }

    .event-detail-icon {
        width: 40px;
        text-align: center;
        color: #6c757d;
        margin-right: 1rem;
    }

    .event-detail-content {
        flex: 1;
    }

    .event-detail-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.25rem;
    }

    .event-detail-value {
        color: #6c757d;
    }

    /* Colores para tipos de actividad */
    .event-tipo-1 {
        background: #e3f2fd;
        color: #1976d2;
        border-left-color: #1976d2;
    }

    .event-tipo-2 {
        background: #f3e5f5;
        color: #7b1fa2;
        border-left-color: #7b1fa2;
    }

    .event-tipo-3 {
        background: #e8f5e8;
        color: #388e3c;
        border-left-color: #388e3c;
    }

    .event-tipo-4 {
        background: #fff3e0;
        color: #f57c00;
        border-left-color: #f57c00;
    }

    .event-tipo-5 {
        background: #fce4ec;
        color: #c2185b;
        border-left-color: #c2185b;
    }

    .event-tipo-6 {
        background: #e1f5fe;
        color: #0277bd;
        border-left-color: #0277bd;
    }

    .event-tipo-7 {
        background: #f3e5f5;
        color: #7b1fa2;
        border-left-color: #7b1fa2;
    }

    .event-tipo-8 {
        background: #e8f5e8;
        color: #388e3c;
        border-left-color: #388e3c;
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
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    // Datos de actividades desde PHP
    const actividades = <?= json_encode($actividades) ?>;
    const baseUrl = '<?= base_url() ?>';

    // Variables globales
    let currentDate = new Date('<?= $currentDate ?>');
    let currentView = '<?= $currentView ?>';

    $(document).ready(function() {
        // Inicializar calendario
        renderCalendar();

        // Navegación del calendario
        $('#prevBtn').on('click', function() {
            if (currentView === 'month') {
                currentDate.setMonth(currentDate.getMonth() - 1);
            } else if (currentView === 'week') {
                currentDate.setDate(currentDate.getDate() - 7);
            } else {
                currentDate.setDate(currentDate.getDate() - 1);
            }
            renderCalendar();
        });

        $('#nextBtn').on('click', function() {
            if (currentView === 'month') {
                currentDate.setMonth(currentDate.getMonth() + 1);
            } else if (currentView === 'week') {
                currentDate.setDate(currentDate.getDate() + 7);
            } else {
                currentDate.setDate(currentDate.getDate() + 1);
            }
            renderCalendar();
        });

        $('#todayBtn').on('click', function() {
            currentDate = new Date();
            renderCalendar();
        });

        // Cambio de vista
        $('.view-tabs .nav-link').on('click', function() {
            currentView = $(this).attr('id').split('-')[0];
            renderCalendar();
        });
    });

    function renderCalendar() {
        updateHeader();

        if (currentView === 'month') {
            renderMonthView();
        } else if (currentView === 'week') {
            renderWeekView();
        } else {
            renderDayView();
        }
    }

    function updateHeader() {
        const options = {
            year: 'numeric',
            month: 'long'
        };
        $('#currentMonth').text(currentDate.toLocaleDateString('es-ES', options));
    }

    function renderMonthView() {
        const calendar = $('#monthCalendar');
        calendar.empty();

        // Encabezados de días
        const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        days.forEach(day => {
            calendar.append(`<div class="calendar-day header">${day}</div>`);
        });

        // Días del mes
        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
        const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);

        // Días del mes anterior
        const prevLastDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 0).getDate();
        const firstDayIndex = firstDay.getDay();

        for (let i = firstDayIndex; i > 0; i--) {
            calendar.append(`<div class="calendar-day other-month">${prevLastDay - i + 1}</div>`);
        }

        // Días del mes actual
        const today = new Date();
        for (let i = 1; i <= lastDay.getDate(); i++) {
            const dayDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);
            const isToday = dayDate.toDateString() === today.toDateString();
            const dayClass = isToday ? 'calendar-day today' : 'calendar-day';

            const dayActividades = getActividadesForDate(dayDate);
            let actividadesHtml = '';

            dayActividades.slice(0, 2).forEach(actividad => {
                const tipoClass = actividad.id_tipo_actividad ? `event-tipo-${actividad.id_tipo_actividad}` : 'event-tipo-1';
                actividadesHtml += `<div class="event-item ${tipoClass}" onclick="mostrarDetalleActividad(${actividad.id})">
                ${actividad.titulo}
            </div>`;
            });

            if (dayActividades.length > 2) {
                actividadesHtml += `<div class="event-more">+${dayActividades.length - 2} más</div>`;
            }

            calendar.append(`
            <div class="${dayClass}">
                <div class="day-number">${i}</div>
                ${actividadesHtml}
            </div>
        `);
        }

        // Días del mes siguiente
        const nextDays = 42 - (firstDayIndex + lastDay.getDate());
        for (let i = 1; i <= nextDays; i++) {
            calendar.append(`<div class="calendar-day other-month">${i}</div>`);
        }
    }

    function renderWeekView() {
        const calendar = $('#weekCalendar');
        calendar.empty();

        // Encabezados de días
        const days = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
        days.forEach(day => {
            calendar.append(`<div class="calendar-day header">${day}</div>`);
        });

        // Obtener inicio de la semana (domingo)
        const startOfWeek = new Date(currentDate);
        startOfWeek.setDate(currentDate.getDate() - currentDate.getDay());

        const today = new Date();

        // Días de la semana
        for (let i = 0; i < 7; i++) {
            const dayDate = new Date(startOfWeek);
            dayDate.setDate(startOfWeek.getDate() + i);

            const isToday = dayDate.toDateString() === today.toDateString();
            const dayClass = isToday ? 'calendar-day today' : 'calendar-day';

            const dayActividades = getActividadesForDate(dayDate);
            let actividadesHtml = '';

            dayActividades.forEach(actividad => {
                const tipoClass = actividad.id_tipo_actividad ? `event-tipo-${actividad.id_tipo_actividad}` : 'event-tipo-1';
                const hora = actividad.hora ? actividad.hora.substring(0, 5) : '';
                actividadesHtml += `<div class="event-item ${tipoClass}" onclick="mostrarDetalleActividad(${actividad.id})">
                <strong>${hora}</strong> - ${actividad.titulo}
            </div>`;
            });

            calendar.append(`
            <div class="${dayClass}">
                <div class="day-number">${dayDate.getDate()}</div>
                ${actividadesHtml}
            </div>
        `);
        }
    }

    function renderDayView() {
        const container = $('#dayCalendar');
        container.empty();

        // Crear estructura de vista diaria con horarios
        const timeSlots = $('<div class="time-slots"></div>');
        const dayEvents = $('<div class="day-events"></div>');

        // Generar slots de tiempo de 7:00 a 22:00
        for (let hour = 7; hour <= 22; hour++) {
            const timeLabel = `${hour.toString().padStart(2, '0')}:00`;
            timeSlots.append(`<div class="time-slot">${timeLabel}</div>`);
        }

        container.append(timeSlots);
        container.append(dayEvents);

        // Obtener actividades del día actual
        const dayActividades = getActividadesForDate(currentDate);

        // Posicionar actividades en la vista diaria
        dayActividades.forEach(actividad => {
            const eventElement = createDayEventElement(actividad);
            dayEvents.append(eventElement);
        });

        // Si no hay actividades, mostrar mensaje
        if (dayActividades.length === 0) {
            dayEvents.append(`
            <div class="text-center py-5 text-muted">
                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                <p>No hay actividades programadas para este día</p>
            </div>
        `);
        }
    }

    function createDayEventElement(actividad) {
        // Calcular posición y altura basado en la hora
        let topPosition = 0;
        let height = 60; // altura por defecto para 1 hora

        if (actividad.hora) {
            const [hours, minutes] = actividad.hora.split(':').map(Number);
            topPosition = (hours - 7) * 60 + minutes;
        }

        // Calcular altura basada en la duración
        if (actividad.duracion) {
            height = Math.max(30, actividad.duracion); // mínimo 30px
        }

        const tipoClass = actividad.id_tipo_actividad ? `event-tipo-${actividad.id_tipo_actividad}` : 'event-tipo-1';
        const hora = actividad.hora ? actividad.hora.substring(0, 5) : 'Sin hora';
        const duracion = actividad.duracion ? `${actividad.duracion} min` : 'Duración no definida';

        return $(`
        <div class="day-event ${tipoClass}" 
             style="top: ${topPosition}px; height: ${height}px;"
             onclick="mostrarDetalleActividad(${actividad.id})">
            <div class="event-time">${hora} - ${duracion}</div>
            <div class="event-title">${actividad.titulo}</div>
            <div class="event-meta">${actividad.sede_nombre || 'Sin sede'} • ${actividad.modalidad_nombre || 'Sin modalidad'}</div>
        </div>
    `);
    }

    function getActividadesForDate(date) {
        const dateString = date.toISOString().split('T')[0];
        return actividades.filter(actividad => actividad.fecha === dateString);
    }

    function mostrarDetalleActividad(actividadId) {
        const actividad = actividades.find(a => a.id == actividadId);
        if (!actividad) return;

        // Actualizar modal con datos de la actividad
        $('#actividadTitle').text(actividad.titulo);

        // Tipo de actividad
        const tipoNombre = actividad.tipo_actividad_nombre || 'Sin tipo';
        const tipoBadgeClass = actividad.id_tipo_actividad ? `badge-tipo-${actividad.id_tipo_actividad}` : 'badge-secondary';
        $('#actividadTypeBadge').text(tipoNombre).removeClass().addClass(`badge ${tipoBadgeClass} event-type-badge`);

        // Fecha y hora
        let fechaHora = 'Fecha no definida';
        if (actividad.fecha) {
            const fecha = new Date(actividad.fecha);
            fechaHora = fecha.toLocaleDateString('es-ES');
            if (actividad.hora) {
                fechaHora += ` - ${actividad.hora.substring(0, 5)}`;
            }
        }
        $('#actividadFechaHora').text(fechaHora);

        // Duración
        $('#actividadDuracion').text(actividad.duracion ? `${actividad.duracion} minutos` : 'No definida');
        $('#actividadSede').text(actividad.sede_nombre || 'No asignada');
        $('#actividadModalidad').text(actividad.modalidad_nombre || 'No asignada');
        $('#actividadDescripcion').text(actividad.descripcion || 'Sin descripción');

        // Botón editar
        $('#btnEditarActividad').attr('href', `${baseUrl}actividades/editar/${actividad.id}`);

        // Mostrar modal
        const modal = new bootstrap.Modal(document.getElementById('modalActividadDetalle'));
        modal.show();
    }
</script>
<?php $this->endSection() ?>