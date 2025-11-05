<!-- JS base -->
<script src="<?= base_url('assets/lib/jquery/jquery.min.js') ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/lib/ionicons/ionicons.js') ?>"></script>
<script src="<?= base_url('assets/js/azia.js') ?>"></script>

<!-- Script adicional para responsividad -->
<script>
$(function () {
  /* Menú móvil */
  $('#azMenuShow').on('click', function (e) {
    e.preventDefault();
    $('#azHeaderMenu').addClass('show');
    $('#azOverlay').addClass('show');
  });
  $('#azMenuClose, #azOverlay').on('click', function (e) {
    e.preventDefault();
    $('#azHeaderMenu').removeClass('show');
    $('#azOverlay').removeClass('show');
  });

  /* Altura de gráficos en móviles */
  function adjustChartHeights() {
    $('.flot-chart').css('height', $(window).width() < 768 ? '120px' : '150px');
  }
  adjustChartHeights();
  $(window).resize(adjustChartHeights);

  /* Ocultar columna en móviles */
  function hideColMob() {
    const $col = $('.table-dashboard th:nth-child(2), .table-dashboard td:nth-child(2)');
    $(window).width() < 576 ? $col.addClass('d-none') : $col.removeClass('d-none');
  }
  hideColMob();
  $(window).resize(hideColMob);
});
</script>