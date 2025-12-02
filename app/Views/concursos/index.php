<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">🏆 Concursos</h2>
                    <p class="az-dashboard-text">Gestione los concursos del Consejo de la Magistratura</p>
                </div>
                <div class="d-flex gap-2">
                    <!-- Toggle de vista -->
                    <div class="view-toggle me-2">
                        <a href="<?= base_url('concursos/cambiar-vista/lista') ?>"
                            class="btn btn-sm <?= ($vista_actual == 'lista') ? 'btn-primary' : 'btn-outline-secondary' ?>"
                            title="Vista Lista">
                            <i class="fas fa-list"></i>
                        </a>
                        <a href="<?= base_url('concursos/cambiar-vista/catalogo') ?>"
                            class="btn btn-sm <?= ($vista_actual == 'catalogo') ? 'btn-primary' : 'btn-outline-secondary' ?>"
                            title="Vista Catálogo">
                            <i class="fas fa-th"></i>
                        </a>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                    <a href="<?= base_url('concursos/nuevo') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Concurso
                    </a>
                </div>
            </div>

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

            <!-- Barra de Filtros y Búsqueda -->
            <div class="filter-bar no-print">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="Buscar por expediente, carátula, estado..."
                                value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <select class="form-select" id="filterEstado">
                            <option value="">Todos los estados</option>
                            <?php foreach ($estados ?? [] as $estado): ?>
                                <option value="<?= $estado['id'] ?>"><?= esc($estado['nombre'] ?? $estado['denominacion']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Vista Catálogo (Cards) -->
            <?php if ($vista_actual == 'catalogo'): ?>
                <div class="row" id="vistaCatalogo">
                    <?php if (empty($concursos)): ?>
                        <div class="col-12">
                            <div class="empty-state py-5">
                                <i class="fas fa-award"></i>
                                <h4>No se encontraron concursos</h4>
                                <p>No hay concursos registrados en el sistema.</p>
                                <a href="<?= base_url('concursos/nuevo') ?>" class="btn btn-primary">
                                    <i class="fas fa-plus me-1"></i> Agregar Primer Concurso
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach ($concursos as $concurso): ?>
                            <?php
                            $estadoClase = '';
                            $estadoTexto = $concurso['estado_denominacion'] ?? 'Sin estado';

                            // Determinar clase CSS basada en el estado
                            if (strpos($estadoTexto, 'Fecha') !== false) {
                                $estadoClase = 'estado-con-fecha';
                            } elseif (strpos($estadoTexto, 'Dictamen') !== false) {
                                $estadoClase = 'estado-dictamen';
                            } elseif (strpos($estadoTexto, 'Psicofísico') !== false) {
                                $estadoClase = 'estado-psicofisico';
                            } elseif (strpos($estadoTexto, 'Provisorio') !== false) {
                                $estadoClase = 'estado-provisorio';
                            } elseif (strpos($estadoTexto, 'Sin Programa') !== false) {
                                $estadoClase = 'estado-sin-programa';
                            } else {
                                $estadoClase = 'estado-default';
                            }
                            ?>
                            <div class="col-md-6 col-lg-4 mb-4" data-estado-id="<?= $concurso['id_estado_concurso'] ?? '' ?>">
                                <div class="concurso-card">
                                    <div class="concurso-header">
                                        <span class="concurso-expediente"><?= esc($concurso['numero_expediente']) ?></span>
                                        <span class="concurso-estado <?= $estadoClase ?>"><?= esc($estadoTexto) ?></span>
                                    </div>

                                    <div class="concurso-titulo"><?= esc($concurso['caratula']) ?></div>

                                    <div class="concurso-meta">
                                        <?php if ($concurso['resolucionSTJ']): ?>
                                            <div class="concurso-meta-item">
                                                <span class="concurso-meta-label">Resolución:</span>
                                                <span class="concurso-meta-value"><?= esc($concurso['resolucionSTJ']) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($concurso['fecha_edicto_publicacion']): ?>
                                            <div class="concurso-meta-item">
                                                <span class="concurso-meta-label">Edicto:</span>
                                                <span class="concurso-meta-value"><?= date('d/m/Y', strtotime($concurso['fecha_edicto_publicacion'])) ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <?php if ($concurso['fecha_escrito']): ?>
                                            <div class="concurso-meta-item">
                                                <span class="concurso-meta-label">Escrito:</span>
                                                <span class="concurso-meta-value"><?= date('d/m/Y', strtotime($concurso['fecha_escrito'])) ?></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

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
                                    </div>

                                    <div class="concurso-actions mt-3">
                                        <a href="<?= base_url("concursos/{$concurso['id']}") ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i> Ver
                                        </a>
                                        <a href="<?= base_url("concursos/editar/{$concurso['id']}") ?>" class="btn btn-outline-warning btn-sm">
                                            <i class="fas fa-edit me-1"></i> Editar
                                        </a>
                                        <button class="btn btn-outline-danger btn-sm"
                                            onclick="confirmarEliminar(<?= $concurso['id'] ?>, '<?= esc($concurso['numero_expediente']) ?>')">
                                            <i class="fas fa-trash me-1"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Vista Lista (Tabla) -->
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover concurso-list-table">
                        <thead>
                            <tr>
                                <th scope="col" width="100">Expediente</th>
                                <th scope="col">Concurso</th>
                                <th scope="col" class="d-none-mobile">Estado</th>
                                <th scope="col" class="d-none-mobile">Postulantes</th>
                                <th scope="col" class="d-none-mobile">Comisión</th>
                                <th scope="col" width="150" class="no-print">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="concursosList">
                            <?php if (empty($concursos)): ?>
                                <tr>
                                    <td colspan="6" class="text-center">
                                        <div class="empty-state py-5">
                                            <i class="fas fa-award"></i>
                                            <h4>No se encontraron concursos</h4>
                                            <p>No hay concursos registrados en el sistema.</p>
                                            <a href="<?= base_url('concursos/nuevo') ?>" class="btn btn-primary">
                                                <i class="fas fa-plus me-1"></i> Agregar Primer Concurso
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($concursos as $concurso): ?>
                                    <tr data-estado-id="<?= $concurso['id_estado_concurso'] ?? '' ?>">
                                        <td class="align-middle">
                                            <div class="concurso-expediente-list"><?= esc($concurso['numero_expediente']) ?></div>
                                        </td>
                                        <td class="align-middle">
                                            <div class="concurso-titulo-list"><?= esc($concurso['caratula']) ?></div>
                                            <div class="concurso-meta-value"><?= esc($concurso['resolucionSTJ'] ?? '') ?></div>
                                        </td>
                                        <td class="align-middle d-none-mobile">
                                            <?php
                                            $estadoClase = '';
                                            $estadoTexto = $concurso['estado_denominacion'] ?? 'Sin estado';

                                            if (strpos($estadoTexto, 'Fecha') !== false) {
                                                $estadoClase = 'estado-con-fecha';
                                            } elseif (strpos($estadoTexto, 'Dictamen') !== false) {
                                                $estadoClase = 'estado-dictamen';
                                            } elseif (strpos($estadoTexto, 'Psicofísico') !== false) {
                                                $estadoClase = 'estado-psicofisico';
                                            } elseif (strpos($estadoTexto, 'Provisorio') !== false) {
                                                $estadoClase = 'estado-provisorio';
                                            } elseif (strpos($estadoTexto, 'Sin Programa') !== false) {
                                                $estadoClase = 'estado-sin-programa';
                                            } else {
                                                $estadoClase = 'estado-default';
                                            }
                                            ?>
                                            <span class="concurso-estado <?= $estadoClase ?>">
                                                <?= esc($estadoTexto) ?>
                                            </span>
                                        </td>
                                        <td class="align-middle d-none-mobile">
                                            <strong><?= $concurso['estadisticas']['total_postulantes'] ?? 0 ?></strong> postulantes<br>
                                            <?php if (isset($concurso['estadisticas']['por_nivel'])): ?>
                                                <?php foreach ($concurso['estadisticas']['por_nivel'] as $nivel => $cantidad): ?>
                                                    <small><?= $nivel ?>: <?= $cantidad ?></small><br>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="align-middle d-none-mobile">
                                            <strong><?= $concurso['estadisticas']['total_comision'] ?? 0 ?></strong> miembros<br>
                                            <small>Titulares: <?= $concurso['estadisticas']['titulares'] ?? 0 ?></small><br>
                                            <small>Suplentes: <?= $concurso['estadisticas']['suplentes'] ?? 0 ?></small>
                                        </td>
                                        <td class="align-middle no-print">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="<?= base_url("concursos/{$concurso['id']}") ?>" class="btn btn-outline-primary" title="Ver detalles">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?= base_url("concursos/editar/{$concurso['id']}") ?>" class="btn btn-outline-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-outline-danger" title="Eliminar"
                                                    onclick="confirmarEliminar(<?= $concurso['id'] ?>, '<?= esc($concurso['numero_expediente']) ?>')">
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
            <?php endif; ?>
        </div>
    </div>
</div>

<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<style>
    /* Estilos para la vista de catálogo */
    .view-toggle {
        display: flex;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        overflow: hidden;
    }

    .view-toggle .btn {
        border-radius: 0;
        border: none;
        padding: 0.375rem 0.75rem;
    }

    .view-toggle .btn:first-child {
        border-right: 1px solid #dee2e6;
    }

    /* Estilos de cards para vista catálogo */
    .concurso-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        height: 100%;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .concurso-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .concurso-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .concurso-expediente {
        background: #e3f2fd;
        color: #1976d2;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .concurso-estado {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .estado-con-fecha {
        background: #e8f5e8;
        color: #2e7d32;
    }

    .estado-dictamen {
        background: #fff3e0;
        color: #ef6c00;
    }

    .estado-psicofisico {
        background: #e3f2fd;
        color: #1565c0;
    }

    .estado-provisorio {
        background: #fce4ec;
        color: #c2185b;
    }

    .estado-sin-programa {
        background: #fff8e1;
        color: #ff8f00;
    }

    .estado-default {
        background: #f5f5f5;
        color: #616161;
    }

    .concurso-titulo {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #2c3e50;
        line-height: 1.3;
        flex-grow: 1;
    }

    .concurso-meta {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    .concurso-meta-item {
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
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
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
        margin-bottom: 1rem;
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
        font-size: 0.7rem;
        color: #6c757d;
    }

    .concurso-actions {
        display: flex;
        gap: 0.5rem;
    }

    .concurso-actions .btn {
        flex: 1;
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }

    /* Estilos para la vista de tabla (existentes) */
    .concurso-list-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .concurso-list-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
    }

    .concurso-list-table tr:hover {
        background-color: #f8f9fa;
    }

    .concurso-titulo-list {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
        line-height: 1.3;
    }

    .concurso-expediente-list {
        font-weight: 600;
        color: #1976d2;
        font-size: 0.9rem;
    }

    .concurso-meta-value {
        font-size: 0.8rem;
        color: #6c757d;
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

    .filter-bar {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .search-bar {
        position: relative;
    }

    .search-bar input {
        padding-left: 2.5rem;
        border-radius: 25px;
    }

    .search-bar i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
    }

    @media (max-width: 767.98px) {
        .d-none-mobile {
            display: none;
        }

        .concurso-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media print {

        .no-print,
        .filter-bar,
        .az-header,
        .az-footer,
        .modal,
        .view-toggle {
            display: none !important;
        }

        .az-content {
            margin-top: 0 !important;
        }

        .concurso-list-table {
            box-shadow: none;
            border: 1px solid #dee2e6;
        }

        .table-responsive {
            font-size: 12px;
        }
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    function confirmarEliminar(id, expediente) {
        if (confirm(`¿Está seguro de eliminar el concurso "${expediente}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('concursos/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Búsqueda en tiempo real para ambas vistas
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();

            <?php if ($vista_actual == 'catalogo'): ?>
                // Filtrado para vista catálogo
                $('.concurso-card').each(function() {
                    const card = $(this);
                    const expediente = card.find('.concurso-expediente').text().toLowerCase();
                    const titulo = card.find('.concurso-titulo').text().toLowerCase();
                    const estado = card.find('.concurso-estado').text().toLowerCase();

                    const cumpleBusqueda = !searchTerm ||
                        expediente.includes(searchTerm) ||
                        titulo.includes(searchTerm) ||
                        estado.includes(searchTerm);

                    card.closest('.col-md-6').toggle(cumpleBusqueda);
                });
            <?php else: ?>
                // Filtrado para vista tabla
                $('tbody tr').each(function() {
                    const expediente = $(this).find('.concurso-expediente-list').text().toLowerCase();
                    const titulo = $(this).find('.concurso-titulo-list').text().toLowerCase();
                    const meta = $(this).find('.concurso-meta-value').text().toLowerCase();
                    const estado = $(this).find('.concurso-estado').text().toLowerCase();

                    const cumpleBusqueda = !searchTerm ||
                        expediente.includes(searchTerm) ||
                        titulo.includes(searchTerm) ||
                        meta.includes(searchTerm) ||
                        estado.includes(searchTerm);

                    $(this).toggle(cumpleBusqueda);
                });
            <?php endif; ?>
        });

        // Filtro por estado para ambas vistas
        $('#filterEstado').on('change', function() {
            const estadoId = $(this).val();

            <?php if ($vista_actual == 'catalogo'): ?>
                // Filtrado para vista catálogo
                $('.concurso-card').each(function() {
                    const card = $(this);
                    const rowEstadoId = card.closest('.col-md-6').data('estado-id');

                    if (!estadoId) {
                        card.closest('.col-md-6').show();
                    } else {
                        if (rowEstadoId == estadoId) {
                            card.closest('.col-md-6').show();
                        } else {
                            card.closest('.col-md-6').hide();
                        }
                    }
                });
            <?php else: ?>
                // Filtrado para vista tabla
                $('tbody tr').each(function() {
                    const rowEstadoId = $(this).data('estado-id');

                    if (!estadoId) {
                        $(this).show();
                    } else {
                        if (rowEstadoId == estadoId) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    }
                });
            <?php endif; ?>
        });

        // Mostrar/ocultar según filtro inicial
        $('#filterEstado').trigger('change');
    });
</script>
<?php $this->endSection() ?>