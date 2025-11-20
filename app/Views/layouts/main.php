<?= view('partials/head_dashboard') ?>
<body>

<?= view('partials/navbar_dashboard') ?>

<div class="az-content az-content-dashboard">
    <div class="container">
        <div class="az-content-body">
            <?= $this->renderSection('content') ?>
        </div>
    </div>
</div>

<?= view('partials/footer_dashboard') ?>
<?= view('partials/scripts_dashboard') ?>
</body>
</html>