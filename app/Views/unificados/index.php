<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">🔗 Gestión de Unificados</h2>
                    <p class="az-dashboard-text">Administre las unificaciones de concursos</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                    <a href="<?= base_url('unificados/nuevo') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nueva Unificación
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
                    <div class="col-md-6">
                        <div class="search-bar">
                            <i class="fas fa-search"></i>
                            <input type="text" class="form-control" id="searchInput"
                                placeholder="Buscar por denominación..."
                                value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Unificados -->
            <div class="table-responsive">
                <table class="table table-hover unificado-list-table">
                    <thead>
                        <tr>
                            <th scope="col" width="50">ID</th>
                            <th scope="col">Denominación</th>
                            <th scope="col" class="d-none-mobile">Fecha Creación</th>
                            <th scope="col" width="150" class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="unificadosList">
                        <?php if (empty($unificados)): ?>
                            <tr>
                                <td colspan="4" class="text-center">
                                    <div class="empty-state py-5">
                                        <i class="fas fa-link"></i>
                                        <h4>No se encontraron unificaciones</h4>
                                        <p>No hay unificaciones registradas en el sistema.</p>
                                        <a href="<?= base_url('unificados/nuevo') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Crear Primera Unificación
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($unificados as $unificado): ?>
                                <tr>
                                    <td class="align-middle">#<?= $unificado['id'] ?></td>
                                    <td class="align-middle">
                                        <div class="unificado-name">
                                            <i class="fas fa-link me-2 text-primary"></i>
                                            <?= esc($unificado['denominacion']) ?>
                                        </div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <?= date('d/m/Y', strtotime($unificado['created_at'])) ?>
                                    </td>
                                    <td class="align-middle no-print">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url("unificados/{$unificado['id']}") ?>" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url("unificados/editar/{$unificado['id']}") ?>" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminar(<?= $unificado['id'] ?>, '<?= esc($unificado['denominacion']) ?>')">
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
    .unificado-list-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .unificado-list-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
    }

    .unificado-list-table tr:hover {
        background-color: #f8f9fa;
    }

    .unificado-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 1rem;
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

        .unificado-list-table {
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
    function confirmarEliminar(id, denominacion) {
        if (confirm(`¿Está seguro de eliminar la unificación "${denominacion}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('unificados/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Búsqueda en tiempo real
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                const denominacion = $(this).find('.unificado-name').text().toLowerCase();
                const cumpleBusqueda = !searchTerm || denominacion.includes(searchTerm);

                $(this).toggle(cumpleBusqueda);
            });
        });
    });
</script>
<?php $this->endSection() ?>