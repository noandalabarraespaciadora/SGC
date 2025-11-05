<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<!-- Mensajes flash (opcional) -->
<?php if (session()->getFlashdata('success')): ?>
  <div class="alert alert-success alert-dismissible fade show"><?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
  <div class="alert alert-danger alert-dismissible fade show"><?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  </div>
<?php endif; ?>

<!-- Título -->
<div class="az-dashboard-one-title">
  <div>
    <h2 class="az-dashboard-title">👋 Hola! <b><?= esc($usuario_nombre) ?></b></h2>
    <p class="az-dashboard-text">Que tengas una excelente jornada laboral!! 😄</p>
  </div>
  <div class="az-content-header-right">
    <div class="media">
      <div class="media-body">
        <label><?= date('l') ?></label>   <!-- Día semana -->
        <h6><?= date('d') . ' de ' . date('F') . ' de ' . date('Y') ?></h6>
      </div>
    </div>
  </div>
</div>
<hr>

<!-- =======  DASHBOARD RESPONSIVO  ======= -->
<div class="row g-3 g-lg-4">
  <!-- IZQUIERDA: Concursos -->
  <div class="col-12 col-lg-7 order-1 order-lg-1">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2">
        <div>
          <h6 class="card-title fs-6 fs-md-5 mb-1">🏆 Concursos</h6>
          <p class="text-muted small mb-0">Consulte los últimos concursos registrados.</p>
        </div>
        <a href="#" class="btn btn-primary btn-sm mt-2 mt-sm-0">Ver todos los concursos</a>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-dashboard align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="text-nowrap">Expte</th>
                <th class="text-nowrap">Nombre</th>
                <th class="text-nowrap">Estado</th>
                <th class="text-nowrap text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div><!-- /col concursos -->

  <!-- DERECHA: Gráficos + Importante -->
  <div class="col-12 col-lg-5 order-2 order-lg-2">
    <div class="row g-3">
      <!-- Docente -->
      <div class="col-12 col-sm-6 col-lg-12">
        <div class="card shadow-sm h-100">
          <div class="card-header d-flex flex-column flex-sm-row justify-content-between align-items-start gap-2">
            <div>
              <h6 class="card-title fs-6 fs-md-5 mb-1">🏆 Docente</h6>
              <p class="text-muted small mb-0">Resumen de docentes.</p>
            </div>
            <a href="#" class="btn btn-primary btn-sm mt-2 mt-sm-0">Ver todos</a>
          </div>
          <div class="card-body">
            <div id="flotChart1" class="flot-chart d-flex justify-content-center align-items-center text-muted" style="height:150px;">
              Gráfico de Docentes
            </div>
          </div>
        </div>
      </div>

      <!-- Postulantes -->
      <div class="col-12 col-sm-6 col-lg-12">
        <div class="card shadow-sm h-100">
          <div class="card-header">
            <h6 class="card-title fs-6 fs-md-5 mb-1">Postulantes <i class="icon ion-md-trending-down tx-danger"></i> <small>0.86 %</small></h6>
            <p class="text-muted small mb-0">Total Users</p>
          </div>
          <div class="card-body">
            <div id="flotChart2" class="flot-chart d-flex justify-content-center align-items-center text-muted" style="height:150px;">
              Gráfico de Postulantes
            </div>
          </div>
        </div>
      </div>

      <!-- Importante -->
      <div class="col-12">
        <div class="card shadow-sm h-100">
          <div class="card-header">
            <p class="mb-0 fw-semibold">📅 Importante</p>
          </div>
          <div class="card-body d-flex align-items-center">
            <p class="mb-0 text-muted">No hay actividades registradas para hoy</p>
          </div>
        </div>
      </div>
    </div><!-- /row anidado -->
  </div><!-- /col derecha -->
</div><!-- /row principal -->
<?php $this->endSection() ?>