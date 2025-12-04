<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Mensajes flash -->
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

            <!-- ======= BÚSQUEDA MEJORADA CON RESULTADOS ======= -->
            <div class="row g-3 g-lg-4">
                <!-- Sección de Búsqueda -->
                <div class="col-12 col-lg-12 order-1 order-lg-1">
                    <div class="card shadow-sm h-100">
                        <div class="card-body p-0">
                            <!-- Hero Section de Búsqueda -->
                            <div class="search-hero">
                                <h4 class="fw-bold mb-2">🔍 Buscador Rápido</h4>
                                <p class="mb-3">Encuentra postulantes y docentes de manera rápida y eficiente</p>
                                <div class="divider"></div>

                                <!-- Barra de búsqueda -->
                                <div class="search-input-group">
                                    <input type="text" class="form-control search-input" id="searchInput"
                                        placeholder="Ingresa un término de búsqueda para encontrar postulantes o docentes."
                                        value="<?= esc($searchTerm ?? '') ?>">
                                    <button class="btn search-btn" id="searchButton">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>

                            <!-- Estados de búsqueda -->
                            <div id="searchStates">
                                <!-- Estado inicial -->
                                <div class="initial-state" id="initialState">
                                    <i class="fas fa-search"></i>
                                    <h4>🧐 Escribe lo que buscas</h4>
                                    <p>Presiona Enter (o haz clic en Buscar) para empezar a encontrar resultados.</p>
                                </div>

                                <!-- Estado sin resultados -->
                                <div class="empty-state d-none" id="noResultsState">
                                    <i class="fas fa-search"></i>
                                    <h4>¡Vaya! 😔 No encontramos resultados</h4>
                                    <p id="noResultsText"></p>
                                    <button class="btn btn-primary mt-2" onclick="clearSearch()">
                                        <i class="fas fa-times me-1"></i> Limpiar búsqueda
                                    </button>
                                </div>

                                <!-- Estado con resultados -->
                                <div class="d-none" id="resultsState">
                                    <div class="search-results-header">
                                        <h5 id="resultsHeader"></h5>
                                        <p class="mb-0">¡Echa un vistazo! 🕵</p>
                                    </div>

                                    <!-- Grid de resultados -->
                                    <div class="row g-3" id="resultsGrid">
                                        <!-- Los resultados se cargarán aquí dinámicamente -->
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div><!-- /.col -->
            </div><!-- /.row principal -->
        </div><!-- az-content-body -->
    </div>
</div><!-- az-content -->
<?php $this->endSection() ?>

<?php $this->section('styles') ?>
<style>
    /* Estilos para el módulo de búsqueda */
    .search-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 0.5rem;
        padding: 2rem;
        margin-bottom: 1.5rem;
        border-left: 4px solid #007bff;
    }

    .search-input-group {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .search-input {
        padding-right: 50px;
        border-radius: 2rem;
        height: 50px;
        font-size: 1rem;
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 5px;
        height: 40px;
        border-radius: 2rem;
        padding: 0 1.5rem;
        background: #007bff;
        border: none;
        color: white;
    }

    .search-btn:hover {
        background: #0056b3;
    }

    .divider {
        height: 1px;
        background: #dee2e6;
        margin: 1.5rem 0;
    }

    .search-results-header {
        margin: 1.5rem 0;
        padding: 1rem;
        background: #e7f3ff;
        border-radius: 10px;
        border-left: 4px solid #007bff;
    }

    .initial-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .initial-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-state {
        text-align: center;
        padding: 3rem;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    /* Estilos para las tarjetas de resultados */
    .postulante-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
    }

    .postulante-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .postulante-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .postulante-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e9ecef;
    }

    .postulante-avatar.bg-secondary {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .postulante-info {
        flex: 1;
        margin: 0 1rem;
    }

    .postulante-name {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: #2c3e50;
    }

    .postulante-meta {
        color: #6c757d;
        font-size: 0.875rem;
    }

    .type-badge {
        position: absolute;
        top: 1rem;
        left: 1rem;
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
        border-radius: 10px;
        background: #6c757d;
        color: white;
    }

    .type-postulante {
        background: #007bff;
    }

    .type-docente {
        background: #28a745;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .status-completo {
        background: #d4edda;
        color: #155724;
    }

    .status-incompleto {
        background: #fff3cd;
        color: #856404;
    }

    .status-vencido {
        background: #f8d7da;
        color: #721c24;
    }

    /* Estilos para el link de la barra de progreso */
    .document-progress-link {
        text-decoration: none;
        display: block;
        cursor: pointer;
        transition: opacity 0.3s ease;
    }

    .document-progress-link:hover {
        opacity: 0.8;
    }

    .document-progress {
        background: #e9ecef;
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        margin: 0.5rem 0;
    }

    .progress-bar {
        height: 100%;
        border-radius: 3px;
    }

    .progress-completo {
        background: #28a745;
    }

    .progress-incompleto {
        background: #ffc107;
    }

    .progress-vencido {
        background: #dc3545;
    }

    .quick-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .action-btn {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .view-btn {
        background: #e3f2fd;
        color: #1976d2;
    }

    .view-btn:hover {
        background: #bbdefb;
        color: #1976d2;
        text-decoration: none;
    }

    .edit-btn {
        background: #fff3e0;
        color: #f57c00;
    }

    .edit-btn:hover {
        background: #ffe0b2;
        color: #f57c00;
        text-decoration: none;
    }

    .print-btn {
        background: #e8f5e8;
        color: #388e3c;
    }

    .print-btn:hover {
        background: #c8e6c9;
        color: #388e3c;
        text-decoration: none;
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .alert-indicator {
        position: absolute;
        top: 1rem;
        right: 1rem;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #dc3545;
        animation: pulse 2s infinite;
    }

    .alert-warning {
        background: #ffc107;
    }

    .alert-success {
        background: #28a745;
    }

    @keyframes pulse {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7);
        }

        70% {
            transform: scale(1);
            box-shadow: 0 0 0 10px rgba(220, 53, 69, 0);
        }

        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(220, 53, 69, 0);
        }
    }

    @media (max-width: 767.98px) {
        .search-hero {
            padding: 1.5rem;
        }

        .postulante-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .postulante-avatar {
            margin-bottom: 1rem;
        }

        .postulante-info {
            margin: 0;
            margin-bottom: 1rem;
        }

        .quick-actions {
            flex-direction: column;
        }
    }

    /* Estilos para el badge de estudios psicofísicos */
    .psicofisico-badge {
        display: inline-block;
        padding: 0.35rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    .psicofisico-vigente {
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .psicofisico-vencido {
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    .psicofisico-sin-datos {
        background: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        const baseUrl = '<?= base_url() ?>';
        const csrfToken = '<?= csrf_hash() ?>';

        // Si hay un término de búsqueda en la URL, realizar búsqueda automática
        const urlParams = new URLSearchParams(window.location.search);
        const searchParam = urlParams.get('q');

        if (searchParam && searchParam.trim() !== '') {
            $('#searchInput').val(searchParam);
            performSearch();
        }

        // Búsqueda al hacer clic en el botón
        $('#searchButton').on('click', function() {
            performSearch();
        });

        // Búsqueda al presionar Enter
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) {
                performSearch();
            }
        });

        // Función para realizar la búsqueda
        function performSearch() {
            const searchTerm = $('#searchInput').val().trim();

            if (searchTerm === '') {
                showInitialState();
                updateUrl('');
                return;
            }

            // Mostrar loading
            $('#initialState').addClass('d-none');
            $('#noResultsState').addClass('d-none');
            $('#resultsState').addClass('d-none');

            // Actualizar URL
            updateUrl(searchTerm);

            // Realizar búsqueda AJAX
            $.ajax({
                url: baseUrl + '/search/search',
                type: 'GET',
                data: {
                    q: searchTerm,
                    csrf_test_name: csrfToken
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        if (response.total === 0) {
                            showNoResultsState(searchTerm);
                        } else {
                            showResultsState(response.results, searchTerm);
                        }
                    } else {
                        showNoResultsState(searchTerm, response.message);
                    }
                },
                error: function() {
                    showNoResultsState(searchTerm, 'Error al realizar la búsqueda');
                }
            });
        }

        // Mostrar estado inicial
        function showInitialState() {
            $('#initialState').removeClass('d-none');
            $('#noResultsState').addClass('d-none');
            $('#resultsState').addClass('d-none');
        }

        // Mostrar estado sin resultados
        function showNoResultsState(searchTerm, customMessage = null) {
            $('#initialState').addClass('d-none');
            $('#noResultsState').removeClass('d-none');
            $('#resultsState').addClass('d-none');

            const message = customMessage ||
                `No encontramos resultados para "<strong>${searchTerm}</strong>". Intenta acortar la palabra o probá con otra. <br/> ¡Seguro que lo encontramos! 🤖`;

            $('#noResultsText').html(message);
        }

        // Mostrar estado con resultados
        function showResultsState(results, searchTerm) {
            $('#initialState').addClass('d-none');
            $('#noResultsState').addClass('d-none');
            $('#resultsState').removeClass('d-none');

            $('#resultsHeader').html(
                `🎉 Hay <span id="resultsCount">${results.length}</span> coincidencias con el término "<span id="searchTerm">${searchTerm}</span>"`
            );

            // Generar el HTML de los resultados
            const resultsGrid = $('#resultsGrid');
            resultsGrid.empty();

            results.forEach(item => {
                const cardHtml = generateCardHtml(item);
                resultsGrid.append(cardHtml);
            });
        }

        // Generar HTML para cada tarjeta
        function generateCardHtml(item) {
            const hasPhoto = item.url_foto !== null && item.url_foto !== '';
            const avatarHtml = hasPhoto ?
                `<img src="${baseUrl}/${item.url_foto}" alt="Avatar" class="postulante-avatar" onerror="this.onerror=null; this.src='${baseUrl}/img/default-avatar.jpg';">` :
                `<div class="postulante-avatar bg-secondary d-flex align-items-center justify-content-center">
                    <i class="fas fa-user text-white"></i>
                </div>`;

            // Determinar nombre completo
            let nombreCompleto = '';
            let dni = '';
            let edad = '';
            let profesion = '';

            if (item.tipo === 'postulante') {
                nombreCompleto = `${item.apellido}, ${item.nombre}`;
                dni = item.dni || 'Sin DNI';
                edad = item.edad ? `${item.edad} años` : '';
                profesion = item.titulo || 'Sin título';
            } else {
                nombreCompleto = item.apellido_y_nombre || 'Sin nombre';
                // Mostrar teléfono y email del docente
                const telefono = item.telefonos && item.telefonos.length > 0 ? item.telefonos[0].numero : 'Sin teléfono';
                const email = item.emails && item.emails.length > 0 ? item.emails[0].direccion : 'Sin email';
                dni = telefono;
                edad = '';
                profesion = email;
            }

            // Badge de tipo
            const typeBadgeClass = item.tipo === 'postulante' ? 'type-postulante' : 'type-docente';
            const typeBadgeText = item.tipo === 'postulante' ? 'Postulante' : 'Docente';

            // Estado de documentación (solo para postulantes)
            let statusHtml = '';
            let progressHtml = '';
            let alertIndicator = '';
            let psicofisicoHtml = '';

            if (item.tipo === 'postulante') {
                // Usar el estado de documentación calculado en el backend
                const estadoDoc = item.estado_documentacion || {
                    estado: 'sin-datos',
                    progreso: 0
                };
                const statusClass = `status-${estadoDoc.estado}`;

                // Determinar el texto según el estado
                let statusText = '';
                if (estadoDoc.progreso === 100) {
                    statusText = 'Vigente';
                } else if (estadoDoc.progreso >= 75) {
                    statusText = 'Completar Documentación';
                } else {
                    statusText = 'Vencida';
                }

                const progressClass = `progress-${estadoDoc.estado}`;

                statusHtml = `<span class="status-badge ${statusClass}">${statusText}</span>`;

                // URL para ver documentación (con parámetro para abrir la pestaña de documentos)
                const docUrl = baseUrl + '/postulantes/' + item.id + '?tab=documentos';

                progressHtml = `
                    <a href="${docUrl}" class="document-progress-link" title="Click para ver la documentación del postulante">
                        <div class="document-progress">
                            <div class="progress-bar ${progressClass}" style="width: ${estadoDoc.progreso}%"></div>
                        </div>
                        <small class="text-muted">Vigencia: ${estadoDoc.progreso}%</small>
                    </a>
                `;

                // Calcular estado de estudios psicofísicos
                const estadoPsicofisico = calcularEstadoPsicofisico(item.estudios_psicofisicos_fecha);
                psicofisicoHtml = `
                    <div class="psicofisico-badge ${estadoPsicofisico.clase}">
                        <i class="fas ${estadoPsicofisico.icono} me-1"></i>
                        ${estadoPsicofisico.texto}
                    </div>
                `;

                // Indicador de alerta
                if (estadoDoc.estado === 'vencido') {
                    alertIndicator = '<div class="alert-indicator"></div>';
                } else if (estadoDoc.estado === 'incompleto') {
                    alertIndicator = '<div class="alert-indicator alert-warning"></div>';
                } else if (estadoDoc.estado === 'completo') {
                    alertIndicator = '<div class="alert-indicator alert-success"></div>';
                }
            }

            // Determinar URL de acción
            const viewUrl = item.tipo === 'postulante' ?
                baseUrl + '/postulantes/' + item.id :
                baseUrl + '/docentes/' + item.id;

            const editUrl = item.tipo === 'postulante' ?
                baseUrl + '/postulantes/editar/' + item.id :
                baseUrl + '/docentes/editar/' + item.id;

            const printUrl = item.tipo === 'postulante' ?
                baseUrl + '/postulantes/print/' + item.id :
                baseUrl + '/docentes/print/' + item.id;

            return `
                <div class="col-md-6 col-lg-4">
                    <div class="postulante-card">
                        ${alertIndicator}
                        <span class="type-badge ${typeBadgeClass}">${typeBadgeText}</span>
                        
                        <div class="postulante-header">
                            ${avatarHtml}
                            <div class="postulante-info">
                                <div class="postulante-name">${nombreCompleto}</div>
                                <div class="postulante-meta">
                                    <div>${dni}</div>
                                    ${edad ? `<div>${edad} · ${profesion}</div>` : `<div>${profesion}</div>`}
                                </div>
                            </div>
                            ${statusHtml}
                        </div>
                        
                        ${progressHtml}

                        ${psicofisicoHtml}
                        
                        <div class="quick-actions">
                            <a href="${viewUrl}" class="action-btn view-btn">
                                <i class="fas fa-eye me-1"></i> Ver
                            </a>
                            <a href="${editUrl}" class="action-btn edit-btn">
                                <i class="fas fa-edit me-1"></i> Editar
                            </a>
                            <a href="${printUrl}" target="_blank" class="action-btn print-btn">
                                <i class="fas fa-print me-1"></i> Imprimir
                            </a>
                        </div>
                    </div>
                </div>
            `;
        }

        // Calcular estado de estudios psicofísicos
        function calcularEstadoPsicofisico(fechaEstudiosPsicofisicos) {
            if (!fechaEstudiosPsicofisicos) {
                return {
                    clase: 'psicofisico-sin-datos',
                    icono: 'fa-question-circle',
                    texto: 'Estudios Psicofísicos: Sin datos'
                };
            }

            // Parsear la fecha correctamente para evitar problemas de zona horaria
            const partes = fechaEstudiosPsicofisicos.split('-');
            const fechaDoc = new Date(partes[0], partes[1] - 1, partes[2]); // año, mes (0-indexed), día

            const hoy = new Date();
            hoy.setHours(0, 0, 0, 0); // Resetear horas para comparar solo fechas

            const fechaVencimiento = new Date(fechaDoc);
            fechaVencimiento.setDate(fechaVencimiento.getDate() + 730); // 2 años = 730 días

            const diasRestantes = Math.ceil((fechaVencimiento - hoy) / (1000 * 60 * 60 * 24));

            // Formatear fecha manualmente para evitar problemas de zona horaria
            const dia = String(fechaDoc.getDate()).padStart(2, '0');
            const mes = String(fechaDoc.getMonth() + 1).padStart(2, '0');
            const anio = fechaDoc.getFullYear();
            const fechaFormateada = `${dia}/${mes}/${anio}`;

            if (diasRestantes < 0) {
                return {
                    clase: 'psicofisico-vencido',
                    icono: 'fa-times-circle',
                    texto: `Psicofísico Vencido: ${fechaFormateada}`
                };
            } else {
                return {
                    clase: 'psicofisico-vigente',
                    icono: 'fa-check-circle',
                    texto: `Psicofísico Vigente: ${fechaFormateada}`
                };
            }
        }

        // Actualizar URL sin recargar la página
        function updateUrl(searchTerm) {
            const url = new URL(window.location);
            if (searchTerm) {
                url.searchParams.set('q', searchTerm);
            } else {
                url.searchParams.delete('q');
            }
            window.history.pushState({}, '', url);
        }
    });

    // Funciones globales
    function clearSearch() {
        $('#searchInput').val('');
        $('#initialState').removeClass('d-none');
        $('#noResultsState').addClass('d-none');
        $('#resultsState').addClass('d-none');

        // Actualizar URL
        const url = new URL(window.location);
        url.searchParams.delete('q');
        window.history.pushState({}, '', url);
    }
</script>
<?php $this->endSection() ?>