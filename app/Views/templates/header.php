<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo ?? 'Sistema de Gestión' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- <link href="<?php echo base_url('assets/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/all.min.css'); ?>" rel="stylesheet"> -->
    <style>
        .auth-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .user-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .stats-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body>
    <?php if (isset($navbar) && $navbar): ?>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
                    <i class="fas fa-shield-alt"></i> Sistema Seguro
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <?php if (session()->get('usuario_nivel') === 'sistema'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('/dashboard/usuarios') ?>">
                                    <i class="fas fa-users"></i> Administrar Usuarios
                                </a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/perfil') ?>">
                                <i class="fas fa-user"></i> Mi Perfil
                            </a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?= session()->get('usuario_alias') ?>
                            </a>
                            <ul class="dropdown-menu">
                                <li><span class="dropdown-item-text">
                                        <small><?= session()->get('usuario_nombre') ?>
                                            <?= session()->get('usuario_apellido') ?></small>
                                    </span></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="<?= base_url('/perfil') ?>">
                                        <i class="fas fa-cog"></i> Configuración
                                    </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('/logout') ?>">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    <?php endif; ?>
    <div class="container">