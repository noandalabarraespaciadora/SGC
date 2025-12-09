<?php $this->extend('layouts/main') ?>

<?php $this->section('content') ?>
<!-- Mensajes flash -->
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

<?php
$date = new DateTime();
$formatterDia = new IntlDateFormatter('es', IntlDateFormatter::FULL, IntlDateFormatter::NONE);
$formatterFecha = new IntlDateFormatter('es', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
$formatterDia->setPattern('EEEE');
$formatterFecha->setPattern('dd \'de\' MMMM \'de\' yyyy');
?>

<!-- Título -->
<div class="az-dashboard-one-title">
  <div>
    <h2 class="az-dashboard-title">👋 Hola! <b><?= esc($usuario_alias) ?></b></h2>
    <p class="az-dashboard-text">Que tengas una excelente jornada laboral!! 😄</p>
  </div>
  <div class="az-content-header-right">
    <div class="media">
      <div class="media-body">
        <label><?= ucfirst($formatterDia->format($date)) ?></label>
        <h6><?= $formatterFecha->format($date) ?></h6>
      </div>
    </div>
  </div>
</div>
<hr>

<!-- ACCESO DIRECTO A MÓDULOS -->
<div class="row g-3 mb-4">
  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('buscar') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-danger-subtle text-danger mb-2 rounded-circle p-3">
          <i class="fas fa-search fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Buscar</h6>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('concursos') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-primary-subtle text-primary mb-2 rounded-circle p-3">
          <i class="fas fa-trophy fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Concursos</h6>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('postulantes') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-success-subtle text-success mb-2 rounded-circle p-3">
          <i class="fas fa-users fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Postulantes</h6>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('docentes') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-info-subtle text-info mb-2 rounded-circle p-3">
          <i class="fas fa-chalkboard-teacher fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Docentes</h6>
      </div>
    </a>
  </div>

  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('biblioteca') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-warning-subtle text-warning mb-2 rounded-circle p-3">
          <i class="fas fa-book fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Biblioteca</h6>
      </div>
    </a>
  </div>

  <div class="col-6 col-md-4 col-lg-2">
    <a href="<?= base_url('sedes') ?>" class="card card-module h-100 text-center text-decoration-none shadow-sm hover-effect">
      <div class="card-body d-flex flex-column align-items-center justify-content-center p-3">
        <div class="icon-box bg-secondary-subtle text-secondary mb-2 rounded-circle p-3">
          <i class="fas fa-building fs-4"></i>
        </div>
        <h6 class="card-title mb-0 text-dark">Sedes</h6>
      </div>
    </a>
  </div>
</div>

<!-- DASHBOARD CONTENT -->
<div class="row g-3 g-lg-4">
  <!-- COLUMNA IZQUIERDA (8/12): Concursos Vigentes -->
  <div class="col-12 col-lg-8">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h6 class="card-title fs-5 mb-1">🏆 Concursos Vigentes</h6>
          <p class="text-muted small mb-0">Listado de concursos activos.</p>
        </div>
        <a href="<?= base_url('concursos') ?>" class="btn btn-primary btn-sm">Ver todos</a>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Expediente</th>
                <th>Carátula</th>
                <th>Estado</th>
                <th class="text-end pe-4">Acción</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($concursos)): ?>
                <?php foreach ($concursos as $concurso): ?>
                  <tr>
                    <td class="ps-4 fw-bold text-primary"><?= esc($concurso['numero_expediente']) ?></td>
                    <td>
                      <div class="text-truncate" style="max-width: 250px;" title="<?= esc($concurso['caratula']) ?>">
                        <?= esc($concurso['caratula']) ?>
                      </div>
                    </td>
                    <td>
                      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25">
                        <?= esc($concurso['estado_denominacion'] ?? 'N/A') ?>
                      </span>
                    </td>
                    <td class="text-end pe-4">
                      <a href="<?= base_url('concursos/ver/' . $concurso['id']) ?>" class="btn btn-sm btn-light text-primary" title="Ver detalles">
                        <i class="fas fa-eye"></i>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" class="text-center py-4 text-muted">
                    <i class="fas fa-inbox fs-4 mb-2 d-block"></i>
                    No hay concursos vigentes para mostrar
                  </td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- COLUMNA DERECHA (4/12): Calendario Rotación -->
  <div class="col-12 col-lg-4">
    <div class="card shadow-sm h-100">
      <div class="card-header d-flex justify-content-between align-items-center">
        <div>
          <h6 class="card-title fs-5 mb-1">📅 Actividades</h6>
          <!-- <p class="text-muted small mb-0"><?= ucfirst($formatterFecha->format(new DateTime())) ?></p> -->
        </div>
        <a href="<?= base_url('rotacion') ?>" class="btn btn-outline-primary btn-sm">
          <i class="fas fa-external-link-alt"></i>
        </a>
      </div>
      <div class="card-body">
        <!-- Mini Calendario -->
        <div class="mini-calendar">
          <div class="d-flex justify-content-between text-center fw-bold mb-2 small text-muted">
            <div style="width: 14.28%">L</div>
            <div style="width: 14.28%">M</div>
            <div style="width: 14.28%">M</div>
            <div style="width: 14.28%">J</div>
            <div style="width: 14.28%">V</div>
            <div style="width: 14.28%">S</div>
            <div style="width: 14.28%">D</div>
          </div>
          <div class="d-flex flex-wrap">
            <?php
            $hoy = new DateTime();
            $primerDiaMes = new DateTime('first day of this month');
            $ultimoDiaMes = new DateTime('last day of this month');

            // Ajuste para empezar en lunes (1 = lunes, 7 = domingo)
            $diaSemanaInicio = $primerDiaMes->format('N');
            $diasVacios = $diaSemanaInicio - 1;

            // Días vacíos previos
            for ($i = 0; $i < $diasVacios; $i++) {
              echo '<div class="mini-day empty" style="width: 14.28%; height: 40px;"></div>';
            }

            // Días del mes
            $diaActual = clone $primerDiaMes;
            while ($diaActual <= $ultimoDiaMes) {
              $fechaStr = $diaActual->format('Y-m-d');
              $esHoy = $fechaStr === $hoy->format('Y-m-d');

              // Buscar rotación para este día
              $color = 'transparent';
              $tooltip = '';
              foreach ($rotaciones as $rotacion) {
                if (substr($rotacion['fecha'], 0, 10) === $fechaStr) {
                  foreach ($tipos_dia as $tipo) {
                    if ($tipo['id'] == $rotacion['tipo_dia_id']) {
                      $color = $tipo['color'];
                      $tooltip = $tipo['nombre'];
                      break 2;
                    }
                  }
                }
              }

              $estilo = $color !== 'transparent' ? "background-color: {$color}; color: white;" : "";
              $claseHoy = $esHoy ? "border border-primary fw-bold" : "";

              echo "<div class='mini-day d-flex align-items-center justify-content-center rounded-circle m-0 p-0 position-relative' 
                            style='width: 14.28%; height: 40px; cursor: default;' title='{$tooltip}'>
                            <span class='d-flex align-items-center justify-content-center rounded-circle {$claseHoy}' 
                                  style='width: 30px; height: 30px; {$estilo} font-size: 0.85rem;'>
                                {$diaActual->format('j')}
                            </span>
                          </div>";

              $diaActual->modify('+1 day');
            }
            ?>
          </div>
        </div>

        <!-- Leyenda compacta -->
        <div class="mt-4 small">
          <h6 class="text-muted small fw-bold mb-2">Referencias:</h6>
          <div class="d-flex flex-wrap gap-2">
            <?php foreach ($tipos_dia as $tipo): ?>
              <div class="d-flex align-items-center me-2 mb-1">
                <span class="d-inline-block rounded-circle me-1" style="width: 10px; height: 10px; background-color: <?= $tipo['color'] ?>;"></span>
                <span class="text-muted" style="font-size: 0.75rem;"><?= $tipo['nombre'] ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .hover-effect {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .hover-effect:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15) !important;
  }

  .icon-box {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
</style>

<?php $this->endSection() ?>