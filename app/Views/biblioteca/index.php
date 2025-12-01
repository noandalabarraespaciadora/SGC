<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <!-- Header del módulo -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="az-dashboard-title">📚 Biblioteca</h2>
                    <p class="az-dashboard-text">Gestione el catálogo de libros disponibles para consulta del personal y postulantes</p>
                </div>
                <div class="d-flex gap-2">
                    <div class="view-toggle me-2">
                        <button class="view-toggle-btn active" id="btnVistaCatalogo" title="Vista Catálogo">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="view-toggle-btn" id="btnVistaLista" title="Vista Lista">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary btn-sm no-print" onclick="window.print()">
                        <i class="fas fa-print me-1"></i> Imprimir
                    </button>
                    <a href="<?= base_url('biblioteca/nuevo') ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> Nuevo Libro
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
                                placeholder="Buscar por título, autor, editorial, ISBN..."
                                value="<?= esc($search ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vista Catálogo (Cards) -->
            <div class="row" id="vistaCatalogo">
                <?php if (empty($libros)): ?>
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-book"></i>
                            <h4>No se encontraron libros</h4>
                            <p>No hay libros registrados en el sistema.</p>
                            <a href="<?= base_url('biblioteca/nuevo') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i> Agregar Primer Libro
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($libros as $libro): ?>
                        <div class="col-md-6 col-lg-4 libro-item">
                            <div class="libro-card">
                                <?php if ($libro['url_foto']): ?>
                                    <img src="<?= base_url($libro['url_foto']) ?>" alt="Portada" class="libro-portada">
                                <?php else: ?>
                                    <div class="libro-portada bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-book text-muted fa-4x"></i>
                                    </div>
                                <?php endif; ?>
                                <div class="libro-titulo"><?= esc($libro['titulo']) ?></div>
                                <div class="libro-autor">por <?= esc($libro['autor'] ?? 'Autor no especificado') ?></div>
                                <div class="libro-editorial"><?= esc($libro['editorial'] ?? 'Editorial no especificada') ?></div>

                                <div class="libro-meta">
                                    <div class="libro-meta-item">
                                        <strong>ISBN:</strong> <?= esc($libro['n_isbn'] ?? 'No disponible') ?>
                                    </div>
                                    <div class="libro-meta-item">
                                        <strong>Inventario:</strong> <?= esc($libro['n_inventario']) ?>
                                    </div>
                                    <?php if ($libro['ubicacion']): ?>
                                        <div class="libro-meta-item">
                                            <strong>Ubicación:</strong> <?= esc($libro['ubicacion']) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="libro-actions">
                                    <a href="<?= base_url("biblioteca/{$libro['id']}") ?>" class="libro-action-btn view-btn">
                                        <i class="fas fa-eye me-1"></i> Ver
                                    </a>
                                    <a href="<?= base_url("biblioteca/editar/{$libro['id']}") ?>" class="libro-action-btn edit-btn">
                                        <i class="fas fa-edit me-1"></i> Editar
                                    </a>
                                    <button class="libro-action-btn delete-btn"
                                        onclick="confirmarEliminar(<?= $libro['id'] ?>, '<?= esc($libro['titulo']) ?>')">
                                        <i class="fas fa-trash me-1"></i> Eliminar
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Vista Lista (Tabla) -->
            <div class="table-responsive d-none" id="vistaLista">
                <table class="table table-hover libro-list-table">
                    <thead>
                        <tr>
                            <th scope="col" width="70">Portada</th>
                            <th scope="col">Libro</th>
                            <th scope="col" class="d-none-mobile">Editorial</th>
                            <th scope="col" class="d-none-mobile">ISBN</th>
                            <th scope="col" class="d-none-mobile">Inventario</th>
                            <th scope="col" width="150" class="no-print">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($libros)): ?>
                            <?php foreach ($libros as $libro): ?>
                                <tr class="libro-item">
                                    <td class="align-middle">
                                        <?php if ($libro['url_foto']): ?>
                                            <img src="<?= base_url($libro['url_foto']) ?>" alt="Portada" class="libro-portada-small">
                                        <?php else: ?>
                                            <div class="libro-portada-small bg-light d-flex align-items-center justify-content-center">
                                                <i class="fas fa-book text-muted"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="align-middle">
                                        <div class="libro-titulo-list"><?= esc($libro['titulo']) ?></div>
                                        <div class="libro-autor-list"><?= esc($libro['autor'] ?? 'Autor no especificado') ?></div>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <?= esc($libro['editorial'] ?? 'No especificada') ?>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <?= esc($libro['n_isbn'] ?? 'No disponible') ?>
                                    </td>
                                    <td class="align-middle d-none-mobile">
                                        <?= esc($libro['n_inventario']) ?>
                                    </td>
                                    <td class="align-middle no-print">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url("biblioteca/{$libro['id']}") ?>" class="btn btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url("biblioteca/editar/{$libro['id']}") ?>" class="btn btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" title="Eliminar"
                                                onclick="confirmarEliminar(<?= $libro['id'] ?>, '<?= esc($libro['titulo']) ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No se encontraron libros.
                                </td>
                            </tr>
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
    .libro-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        height: 100%;
    }

    .libro-card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }

    .libro-portada {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        margin-bottom: 1rem;
    }

    .libro-titulo {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #2c3e50;
        line-height: 1.3;
    }

    .libro-autor {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
    }

    .libro-editorial {
        color: #495057;
        font-size: 0.85rem;
        margin-bottom: 0.5rem;
    }

    .libro-meta {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        margin: 1rem 0;
    }

    .libro-meta-item {
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }

    .libro-meta-item:last-child {
        margin-bottom: 0;
    }

    .libro-actions {
        display: flex;
        gap: 0.5rem;
    }

    .libro-action-btn {
        flex: 1;
        padding: 0.5rem;
        border: none;
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        text-decoration: none;
        text-align: center;
        cursor: pointer;
    }

    .view-btn {
        background: #e3f2fd;
        color: #1976d2;
    }

    .edit-btn {
        background: #fff3e0;
        color: #f57c00;
    }

    .delete-btn {
        background: #ffebee;
        color: #d32f2f;
    }

    .libro-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .libro-list-table {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .libro-list-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #2c3e50;
    }

    .libro-list-table tr:hover {
        background-color: #f8f9fa;
    }

    .libro-portada-small {
        width: 50px;
        height: 70px;
        object-fit: cover;
        border-radius: 5px;
    }

    .libro-titulo-list {
        font-weight: 600;
        color: #2c3e50;
    }

    .libro-autor-list {
        font-size: 0.875rem;
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

    .view-toggle-btn:first-child {
        border-right: 1px solid #dee2e6;
    }

    @media print {

        .no-print,
        .filter-bar,
        .view-toggle {
            display: none !important;
        }
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('scripts') ?>
<script>
    function confirmarEliminar(id, titulo) {
        if (confirm(`¿Está seguro de eliminar el libro "${titulo}"?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `<?= base_url('biblioteca/eliminar/') ?>${id}`;
            form.submit();
        }
    }

    $(document).ready(function() {
        // Control de cambio de vista
        $('#btnVistaCatalogo').on('click', function() {
            cambiarVista('catalogo');
        });

        $('#btnVistaLista').on('click', function() {
            cambiarVista('lista');
        });

        // Búsqueda en tiempo real
        $('#searchInput').on('input', function() {
            filtrarLibros();
        });
    });

    function cambiarVista(vista) {
        if (vista === 'catalogo') {
            $('#btnVistaCatalogo').addClass('active');
            $('#btnVistaLista').removeClass('active');
            $('#vistaCatalogo').removeClass('d-none');
            $('#vistaLista').addClass('d-none');
        } else {
            $('#btnVistaCatalogo').removeClass('active');
            $('#btnVistaLista').addClass('active');
            $('#vistaCatalogo').addClass('d-none');
            $('#vistaLista').removeClass('d-none');
        }
    }

    function filtrarLibros() {
        const searchTerm = $('#searchInput').val().toLowerCase();

        $('.libro-item').each(function() {
            const titulo = $(this).find('.libro-titulo, .libro-titulo-list').text().toLowerCase();
            const autor = $(this).find('.libro-autor, .libro-autor-list').text().toLowerCase();
            const editorial = $(this).find('.libro-editorial, td:nth-child(3)').text().toLowerCase();
            const isbn = $(this).find('.libro-meta-item:contains("ISBN")').text().toLowerCase() ||
                $(this).find('td:nth-child(4)').text().toLowerCase();
            const inventario = $(this).find('.libro-meta-item:contains("Inventario")').text().toLowerCase() ||
                $(this).find('td:nth-child(5)').text().toLowerCase();

            const cumpleBusqueda = !searchTerm ||
                titulo.includes(searchTerm) ||
                autor.includes(searchTerm) ||
                editorial.includes(searchTerm) ||
                isbn.includes(searchTerm) ||
                inventario.includes(searchTerm);

            $(this).toggle(cumpleBusqueda);
        });
    }
</script>
<?php $this->endSection() ?>