<?= view('partials/header_login') ?>

<div class="az-signup-wrapper">
    <!-- Columna izquierda (logo + título) -->
    <div class="az-column-signup-left">
        <div class="az-signup-header">
            <i class="typcn typcn-location-arrow-outline"></i>
            <h1>SGC<span></span></h1>
            <h2>Sistema de Gestión de Concursos</h2>
            <h5 class="text-muted">
                Dirección General de Tecnología<br>
                Consejo de la Magistratura y Jurado de Enjuiciamiento<br>
                Provincia del Chaco
            </h5>
        </div>
    </div><!-- az-column-signup-left -->

    <!-- Columna derecha (formulario) -->
    <div class="az-column-signup d-flex flex-column justify-content-center align-items-center">
        <div class="az-signup-header" style="width: 100%; max-width: 400px;">
            <h2>Verificación de Seguridad</h2>
            <h5 class="text-muted">Responde tu pregunta de seguridad para continuar.</h5>

            <!-- Mensajes flash / errores -->
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

            <?php if (isset($errors) && $errors): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $e): ?>
                            <li><?= $e ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Formulario -->
            <form action="<?= base_url('auth/verificar-respuesta') ?>" method="post">
                <?= csrf_field() ?>
                <input type="hidden" name="email" value="<?= $email ?>">

                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title">🔒 Pregunta de Seguridad</h6>
                        <p class="card-text"><?= $pregunta_seguridad ?></p>
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label>Tu respuesta *</label>
                    <input type="text" name="respuesta_seguridad" class="form-control" 
                           placeholder="Escribe tu respuesta" required>
                    <small class="text-muted">No importan las mayúsculas o minúsculas</small>
                </div>

                <button type="submit" class="btn btn-az-primary btn-block w-100 mb-3">Verificar Respuesta</button>
                
                <div class="text-center">
                    <a href="<?= base_url('recuperar-password') ?>" class="text-muted">
                        <i class="fas fa-arrow-left"></i> Volver atrás
                    </a>
                </div>
            </form>
        </div><!-- az-signup-header -->
    </div><!-- az-column-signup -->
</div><!-- az-signup-wrapper -->

<?= view('partials/footer_login') ?>