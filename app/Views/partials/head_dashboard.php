<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="SGC - Sistema Gestión de Concursos - CMyJE">
  <meta name="author" content="Dirección General de Tecnología">
  <title><?= esc($title ?? 'SGC - Dashboard') ?></title>

  <!-- CSS externos -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Assets locales -->
  <link rel="stylesheet" href="<?= base_url('assets/lib/fontawesome-free/css/all.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/lib/ionicons/css/ionicons.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/lib/typicons.font/typicons.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/lib/flag-icon-css/css/flag-icon.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/azia.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/azia-shadcn.css') ?>">

  <!-- Estilos adicionales para responsividad -->
  <style>
    .table-responsive {
      font-size: 0.875rem;
    }

    @media (max-width: 575.98px) {
      .table-responsive {
        font-size: 0.8rem;
      }

      .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.775rem;
      }

      .az-dashboard-title {
        font-size: 1.25rem;
      }

      .card-title {
        font-size: 0.9rem;
      }

      .az-header h2 {
        font-size: 1.25rem;
      }
    }

    @media (max-width: 767.98px) {
      .az-header-menu {
        position: fixed;
        top: 0;
        left: -280px;
        width: 280px;
        height: 100vh;
        background: #fff;
        z-index: 1050;
        transition: all 0.3s;
        overflow-y: auto;
        box-shadow: 0 0 15px rgba(0, 0, 0, .1);
      }

      .az-header-menu.show {
        left: 0;
      }

      .az-header-menu .close {
        position: absolute;
        top: 15px;
        right: 15px;
        font-size: 1.5rem;
        color: #333;
      }

      .az-content {
        margin-top: 60px;
      }

      .table-dashboard th,
      .table-dashboard td {
        padding: 0.5rem;
      }
    }

    .az-overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(0, 0, 0, .5);
      z-index: 1040;
    }

    .az-overlay.show {
      display: block;
    }
  </style>

  <style>
    .az-img-user img {
      border-radius: 50%;
      object-fit: cover;
    }

    .az-header-profile .az-img-user {
      width: 80px;
      height: 80px;
      margin: 0 auto 15px;
    }

    .az-header-profile .az-img-user img {
      width: 100%;
      height: 100%;
      border: 3px solid #f0f0f0;
    }

    .badge {
      font-size: 0.7em;
      padding: 0.35em 0.65em;
    }
  </style>
</head>