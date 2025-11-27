<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">⚙️ Configuración - Sedes</h2>
        <p class="az-dashboard-text">Gestión de Sedes del Consejo</p>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body">
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

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="d-flex gap-2">
                <a href="<?= base_url('sedes/nuevo') ?>" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Nueva
                </a>
                <button class="btn btn-outline-secondary btn-sm" onclick="window.print()">
                    <i class="fas fa-print"></i> Imprimir
                </button>
            </div>
            <div class="d-flex align-items-center gap-2">
                <form method="get" class="d-flex">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Buscar..." value="<?= esc($search ?? '') ?>" style="width:250px;">
                    <button type="submit" class="btn btn-outline-primary btn-sm ms-2">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Denominación</th>
                        <th>Dirección</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sedes)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                No se encontraron sedes.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sedes as $index => $sede): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= esc($sede['denominacion']) ?></strong></td>
                                <td><?= esc($sede['direccion'] ?? '-') ?></td>
                                <td><?= esc($sede['email'] ?? '-') ?></td>
                                <td><?= esc($sede['telefono'] ?? '-') ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url("sedes/{$sede['id']}") ?>" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url("sedes/editar/{$sede['id']}") ?>" 
                                           class="btn btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" title="Eliminar" 
                                                onclick="confirmarEliminar(<?= $sede['id'] ?>, '<?= esc($sede['denominacion']) ?>')">
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

<form id="deleteForm" method="post" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
function confirmarEliminar(id, denominacion) {
    if (confirm(`¿Está seguro de eliminar la sede "${denominacion}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `<?= base_url('sedes/eliminar/') ?>${id}`;
        form.submit();
    }
}
</script>
<?php $this->endSection() ?>