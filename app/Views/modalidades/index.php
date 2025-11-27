<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<div class="az-dashboard-one-title">
    <div>
        <h2 class="az-dashboard-title">⚙️ Configuración - Modalidades</h2>
        <p class="az-dashboard-text">Gestión de Modalidades</p>
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
                <a href="<?= base_url('modalidades/nuevo') ?>" class="btn btn-primary btn-sm">
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
                        <th>Modalidad</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($modalidades)): ?>
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">
                                No se encontraron modalidades.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($modalidades as $index => $modalidad): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= esc($modalidad['modalidad']) ?></td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url("modalidades/{$modalidad['id']}") ?>" 
                                           class="btn btn-outline-primary" title="Ver">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url("modalidades/editar/{$modalidad['id']}") ?>" 
                                           class="btn btn-outline-warning" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button class="btn btn-outline-danger" title="Eliminar" 
                                                onclick="confirmarEliminar(<?= $modalidad['id'] ?>, '<?= esc($modalidad['modalidad']) ?>')">
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
function confirmarEliminar(id, modalidad) {
    if (confirm(`¿Está seguro de eliminar la modalidad "${modalidad}"?`)) {
        const form = document.getElementById('deleteForm');
        form.action = `<?= base_url('modalidades/eliminar/') ?>${id}`;
        form.submit();
    }
}
</script>
<?php $this->endSection() ?>