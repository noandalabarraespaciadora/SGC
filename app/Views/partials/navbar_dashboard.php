<!-- Overlay para móviles -->
<div class="az-overlay" id="azOverlay"></div>

<div class="az-header">
  <div class="container">
    <div class="az-header-left">
      <h2 class="text-default">
        <i class="typcn typcn-location-arrow-outline"></i>
        <a href="<?= base_url('/') ?>">SGC</a>
      </h2>
      <a href="#" id="azMenuShow" class="az-header-menu-icon d-lg-none"><span></span></a>
    </div><!-- az-header-left -->

    <div class="az-header-menu" id="azHeaderMenu">
      <div class="az-header-menu-header">
        <h2 class="text-default"><i class="typcn typcn-location-arrow-outline"></i><a
            href="<?= base_url('/') ?>">SGC</a></h2>
        <a href="#" class="close" id="azMenuClose">&times;</a>
      </div>
      <ul class="nav">
        <li class="nav-item active show">
          <a href="<?= base_url('/') ?>" class="nav-link"><i class="typcn typcn-star-outline"></i>Panel Principal</a>
        </li>
        <li class="nav-item"><a href="#" class="nav-link"><i class="typcn typcn-zoom-outline"></i> Buscar</a></li>
        <li class="nav-item"><a href="#" class="nav-link"><i class="typcn typcn-group-outline"></i> Postulantes</a></li>
        <li class="nav-item"><a href="<?= base_url('docentes') ?>" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Docentes</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link with-sub"><i class="typcn typcn-puzzle-outline"></i> Módulos</a>
          <nav class="az-menu-sub">
            <a href="<?= base_url('actividades') ?>" class="nav-link">Actividades</a>
            <a href="<?= base_url('biblioteca') ?>" class="nav-link">Biblioteca</a>
            <a href="<?= base_url('concursos') ?>" class="nav-link">Concursos</a>
          </nav>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link with-sub"><i class="typcn typcn-cog-outline"></i> Configuración</a>
          <div class="az-menu-sub">
            <div class="container">
              <nav class="nav">
                <a href="<?= base_url('niveles-excelencia') ?>" class="nav-link">Niveles de Excelencia</a>
                <a href="<?= base_url('modalidades') ?>" class="nav-link">Modalidades</a>
                <a href="<?= base_url('representaciones') ?>" class="nav-link">Representación</a>
                <a href="<?= base_url('sedes') ?>" class="nav-link">Sedes</a>
                <a href="#" class="nav-link">Sistema</a>
                <a href="<?= base_url('tipo-actividades') ?>" class="nav-link">Tipos de Actividades</a>
                <a href="<?= base_url('estado-concursos') ?>" class="nav-link">Estado de Concurso</a>
              </nav>
            </div>
          </div>
        </li>
      </ul>
    </div><!-- az-header-menu -->

    <div class="az-header-right">
      <div class="dropdown az-profile-menu">
        <!-- Avatar generado dinámicamente -->
        <a href="#" class="az-img-user">
          <img src="https://ui-avatars.com/api/?name=<?= urlencode(($usuario_nombre ?? '') . '+' . ($usuario_apellido ?? '')) ?>&background=random&color=fff&size=40"
            alt="<?= esc($usuario_nombre ?? 'Usuario') ?>">
        </a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <div class="az-header-profile">
            <!-- Avatar en el dropdown -->
            <div class="az-img-user">
              <img src="https://ui-avatars.com/api/?name=<?= urlencode(($usuario_nombre ?? '') . '+' . ($usuario_apellido ?? '')) ?>&background=random&color=fff&size=80"
                alt="<?= esc($usuario_nombre ?? 'Usuario') ?>">
            </div>

            <!-- Información del usuario -->
            <h6 class="text-center mb-1">
              <?= esc($usuario_nombre ?? 'Nombre') ?> <?= esc($usuario_apellido ?? 'Apellido') ?>
            </h6>

            <!-- Mensaje de estado -->
            <?php if (isset($usuario_mensaje_estado) && !empty($usuario_mensaje_estado)): ?>
              <p class="text-muted small mb-1">"<?= esc($usuario_mensaje_estado) ?>"</p>
            <?php else: ?>
              <p class="text-muted small mb-1">Sin mensaje de estado</p>
            <?php endif; ?>

            <!-- Badge del rol -->
            <?php if (isset($usuario_rol)): ?>
              <span class="badge 
                <?= $usuario_rol == 'Sistemas' ? 'bg-danger' : ($usuario_rol == 'Experto' ? 'bg-warning' : 'bg-primary') ?>">
                <?= $usuario_rol ?>
              </span>
            <?php else: ?>
              <span class="badge bg-secondary">Usuario</span>
            <?php endif; ?>
          </div>

          <!-- Enlaces del menú -->
          <a href="<?= base_url('perfil') ?>" class="dropdown-item">
            <i class="typcn typcn-user-outline"></i> Mis datos
          </a>
          <a href="<?= base_url('logout') ?>" class="dropdown-item">
            <i class="typcn typcn-power-outline"></i> Salir
          </a>
        </div><!-- dropdown-menu -->
      </div>
    </div><!-- az-header-right -->
  </div><!-- container -->
</div><!-- az-header -->