<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">👥 Gestión de Postulantes</h2>
                    <p class="az-dashboard-text">Administre los postulantes a concursos en el sistema</p>
                </div>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                    <a href="<?= base_url('postulantes/nuevo') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Postulante
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
                                placeholder="Buscar por nombre, apellido o DNI..."
                                value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Postulantes -->
            <div class="table-responsive">
                <table class="table table-hover postulante-list-table">
                    <thead>
                        <tr>
                            <th scope="col" width="50">ID</th>
                            <th scope="col">Postulante</th>
                            <th scope="col" class="d-none-mobile">DNI</th>
                            <th scope="col" class="d-none-mobile">Teléfonos</th>
                            <th scope="col" class="d-none-mobile">Emails</th>
                            <th scope="col" width="150" class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="postulantesList">
                        <?php if (empty($postulantes)): ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="empty-state py-5">
                                        <i class="fas fa-user-friends"></i>
                                        <h4>No se encontraron postulantes</h4>
                                        <p>No hay postulantes registrados en el sistema.</p>
                                        <a href="<?= base_url('postulantes/nuevo') ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Agregar Primer Postulante
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($postulantes as $postulante): ?>
                                <tr>
                                    <td class="align-middle">#<?= $postulante['id'] ?></td>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <?php if ($postulante['url_foto']): ?>
                                                <img src="<?= base_url($postulante['url_foto']) ?>" alt="Foto" class="postulante-avatar">
                                            <?php else: ?>
                                                <div class="postulante-avatar bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div class="ms-3">
                                                <div class="postulante-name"><?= esc($postulante['apellido']) ?>, <?= esc($postulante['nombre']) ?></div>
                                                <div class="contact-info d-md-none">
                                                    <div><i class="fas fa-id-card me-1"></i><?= esc($postulante['dni']) ?></div>
                                                    <?php if (!empty($postulante['telefonos'])): ?>
                                                        <div><i class="fas fa-phone me-1"></i><?= esc($postulante['telefonos'][0]['numero']) ?></div>
                                                    <?php endif; ?>
                                                    <?php if (!empty($postulante['emails'])): ?>
                                                        <div><i class="fas fa-envelope me-1"></i><?= esc($postulante['emails'][0]['direccion']) ?></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <?= esc($postulante['dni']) ?>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <div class="contact-info">
                                            <?php if (!empty($postulante['telefonos'])): ?>
                                                <?php foreach ($postulante['telefonos'] as $telefono): ?>
                                                    <div><?= esc($telefono['numero']) ?></div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin teléfono</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <div class="contact-info">
                                            <?php if (!empty($postulante['emails'])): ?>
                                                <?php foreach ($postulante['emails'] as $email): ?>
                                                    <div><?= esc($email['direccion']) ?></div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <span class="text-muted">Sin email</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="align-middle no-print">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url("postulantes/{$postulante['id']}") ?>" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url("postulantes/editar/{$postulante['id']}") ?>" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminar(<?= $postulante['id'] ?>, '<?= esc($postulante['apellido']) ?>, <?= esc($postulante['nombre']) ?>')">
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
    .postulante-list-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .postulante-list-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
    }

    .postulante-list-table tr:hover {
        background-color: #f8f9fa;
    }

    .postulante-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e9ecef;
    }

    .postulante-name {
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

        .postulante-list-table {
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
        if (confirm(`¿Está seguro de eliminar al postulante "${nombre}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('postulantes/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Búsqueda en tiempo real
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();

            $('tbody tr').each(function() {
                const nombreCompleto = $(this).find('.postulante-name').text().toLowerCase();
                const dni = $(this).find('td:nth-child(3)').text().toLowerCase();
                const telefonos = $(this).find('td:nth-child(4)').text().toLowerCase();
                const emails = $(this).find('td:nth-child(5)').text().toLowerCase();

                const cumpleBusqueda = !searchTerm ||
                    nombreCompleto.includes(searchTerm) ||
                    dni.includes(searchTerm) ||
                    telefonos.includes(searchTerm) ||
                    emails.includes(searchTerm);

                $(this).toggle(cumpleBusqueda);
            });
        });
    });
</script>
<?php $this->endSection() ?>