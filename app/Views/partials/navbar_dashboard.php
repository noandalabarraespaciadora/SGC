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
        <li class="nav-item"><a href="#" class="nav-link"><i class="typcn typcn-chart-bar-outline"></i> Docentes</a>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link with-sub"><i class="typcn typcn-puzzle-outline"></i> Módulos</a>
          <nav class="az-menu-sub">
            <a href="#" class="nav-link">Actividades</a>
            <a href="#" class="nav-link">Biblioteca</a>
            <a href="#" class="nav-link">Concursos</a>
          </nav>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link with-sub"><i class="typcn typcn-cog-outline"></i> Configuración</a>
          <div class="az-menu-sub">
            <div class="container">
              <nav class="nav">
                <a href="#" class="nav-link">Niveles de Excelencia</a>
                <a href="#" class="nav-link">Modalidades</a>
                <a href="#" class="nav-link">Representación</a>
                <a href="#" class="nav-link">Sedes</a>
                <a href="#" class="nav-link">Sistema</a>
                <a href="#" class="nav-link">Tipos de Actividades</a>
                <a href="#" class="nav-link">Estado de Concurso</a>
              </nav>
            </div>
          </div>
        </li>
      </ul>
    </div><!-- az-header-menu -->

    <div class="az-header-right">
      <div class="dropdown az-profile-menu">
        <a href="#" class="az-img-user"><img src="<?= base_url('assets/img/faces/face1.jpg') ?>" alt=""></a>
        <div class="dropdown-menu">
          <div class="az-dropdown-header d-sm-none">
            <a href="#" class="az-header-arrow"><i class="icon ion-md-arrow-back"></i></a>
          </div>
          <div class="az-header-profile">
            <div class="az-img-user"><img src="<?= base_url('assets/img/faces/face1.jpg') ?>" alt=""></div>
            <h6 class="text-center"><?= esc($usuario_nombre ?? 'Usuario') ?></h6>
            <span class="muted"><?= esc($usuario_nivel ?? 'Rol') ?></span>

          </div>
          <a href="<?= base_url('perfil') ?>" class="dropdown-item"><i class="typcn typcn-user-outline"></i>Mis
          datos</a>
          <a href="<?= base_url('logout') ?>" class="dropdown-item"><i class="typcn typcn-power-outline"></i> Salir</a>
        </div><!-- dropdown-menu -->
      </div>
    </div><!-- az-header-right -->
  </div><!-- container -->
</div><!-- az-header -->

