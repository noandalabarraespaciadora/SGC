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
                                <option value="<?= $estado['id'] ?>"><?= esc($estado['denominacion']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Listado de Concursos -->
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
                                <tr>
                                    <td class="align-middle">
                                        <div class="concurso-expediente-list"><?= esc($concurso['numero_expediente']) ?></div>
                                    </td>
                                    <td class="align-middle">
                                        <div class="concurso-titulo-list"><?= esc($concurso['caratula']) ?></div>
                                        <div class="concurso-meta-value"><?= esc($concurso['resolucionSTJ'] ?? '') ?></div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <span class="concurso-estado estado-<?= $concurso['estado_denominacion'] ?? 'default' ?>">
                                            <?= esc($concurso['estado_denominacion'] ?? 'Sin estado') ?>
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
        </div>
    </div>
</div>

<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<style>
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

    .concurso-estado {
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
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

    .estado-default {
        background: #f5f5f5;
        color: #616161;
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
    }

    @media print {

        .no-print,
        .filter-bar,
        .az-header,
        .az-footer,
        .modal {
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
        // Búsqueda en tiempo real
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();

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
        });

        // Filtro por estado
        $('#filterEstado').on('change', function() {
            const estadoId = $(this).val();

            $('tbody tr').each(function() {
                const estadoElement = $(this).find('.concurso-estado');
                const estadoText = estadoElement.text().toLowerCase();

                if (!estadoId) {
                    $(this).show();
                } else {
                    // En una implementación real, aquí compararíamos por ID
                    // Por ahora solo mostramos/ocultamos
                    $(this).show();
                }
            });
        });
    });
</script>
<?php $this->endSection() ?>