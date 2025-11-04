<?= $this->include('templates/header') ?>

<div class="auth-container">
    <h2 class="text-center mb-4">Iniciar Sesión</h2>
    
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    
    <?php if (isset($errors)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/procesar-login') ?>" method="post">
        <?= csrf_field() ?>
        
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= old('email') ?>" required>
        </div>
        
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        
        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
    </form>
    
    <div class="text-center mt-3">
        <a href="<?= base_url('register') ?>">¿No tienes cuenta? Regístrate</a>
    </div>
</div>

<?= $this->include('templates/footer') ?>