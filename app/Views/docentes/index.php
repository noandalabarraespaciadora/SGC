<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">👨‍🏫 Gestión de Docentes</h2>
                    <p class="az-dashboard-text">Administre y supervise los docentes integrantes de las comisiones examinadoras</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                    <a href="<?= base_url('docentes/nuevo') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Docente
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
                                placeholder="Buscar por nombre, apellido..."
                                value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Docentes -->
            <div class="table-responsive">
                <table class="table table-hover docente-list-table">
                    <thead>
                        <tr>
                            <th scope="col" width="50">ID</th>
                            <th scope="col">Docente</th>
                            <th scope="col" class="d-none-mobile">Teléfonos</th>
                            <th scope="col" class="d-none-mobile">Emails</th>
                            <th scope="col" width="150" class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="docentesList">
                        <?php if (empty($docentes)): ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="empty-state py-5">
                                        <i class="fas fa-user-graduate"></i>
                                        <h4>No se encontraron docentes</h4>
                                        <p>No hay docentes registrados en el sistema.</p>
                                        <a href="<?= base_url('docentes/nuevo') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Agregar Primer Docente
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($docentes as $docente): ?>
                                <tr>
                                    <td class="align-middle">#<?= $docente['id'] ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <?php if ($docente['url_foto']): ?>
                                                <img src="<?= base_url($docente['url_foto']) ?>" alt="Foto" class="docente-avatar">
                                            <?php else: ?>
                                                <div class="docente-avatar bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user-graduate text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ms-3">
                                                <div class="docente-name"><?= esc($docente['apellido_y_nombre']) ?></div>
                                                <div class="contact-info d-md-none">
                                                    <?php if (!empty($docente['telefonos'])): ?>
                                                        <div><i class="fas fa-phone me-1"></i><?= esc($docente['telefonos'][0]['numero']) ?></div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($docente['emails'])): ?>
                                                        <div><i class="fas fa-envelope me-1"></i><?= esc($docente['emails'][0]['direccion']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <div class="contact-info">
                                            <?php if (!empty($docente['telefonos'])): ?>
                                                <?php foreach ($docente['telefonos'] as $telefono): ?>
                                                    <div><?= esc($telefono['numero']) ?></div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin teléfono</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <div class="contact-info">
                                            <?php if (!empty($docente['emails'])): ?>
                                                <?php foreach ($docente['emails'] as $email): ?>
                                                    <div><?= esc($email['direccion']) ?></div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin email</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle no-print">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url("docentes/{$docente['id']}") ?>" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url("docentes/editar/{$docente['id']}") ?>" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminar(<?= $docente['id'] ?>, '<?= esc($docente['apellido_y_nombre']) ?>')">
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
    .docente-list-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .docente-list-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
    }

    .docente-list-table tr:hover {
        background-color: #f8f9fa;
    }

    .docente-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .docente-name {
        font-weight: 600;
        color: #2c3e50;
    }

    .contact-info {
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

        .docente-list-table {
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
    function confirmarEliminar(id, nombre) {
        if (confirm(`¿Está seguro de eliminar al docente "${nombre}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('docentes/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Búsqueda en tiempo real
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                const nombre = $(this).find('.docente-name').text().toLowerCase();
                const telefonos = $(this).find('td:nth-child(3)').text().toLowerCase();
                const emails = $(this).find('td:nth-child(4)').text().toLowerCase();

                const cumpleBusqueda = !searchTerm ||
                    nombre.includes(searchTerm) ||
                    telefonos.includes(searchTerm) ||
                    emails.includes(searchTerm);

                $(this).toggle(cumpleBusqueda);
            });
        });
    });
</script>
<?php $this->endSection() ?>