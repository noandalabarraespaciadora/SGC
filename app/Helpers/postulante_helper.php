<?php

/**
 * Helper para verificar la vigencia de documentos de postulantes
 * 
 * @param string|null $fechaDocumento Fecha del documento
 * @param int $diasVigencia Días de vigencia del documento
 * @return string HTML con el badge de estado
 */
if (!function_exists('verificarVigenciaDocumento')) {
    function verificarVigenciaDocumento($fechaDocumento, $diasVigencia)
    {
        if (!$fechaDocumento) {
            return '<span class="badge bg-secondary">No presentado</span>';
        }

        $fechaDoc = new DateTime($fechaDocumento);
        $hoy = new DateTime();
        $fechaVencimiento = clone $fechaDoc;
        $fechaVencimiento->modify("+{$diasVigencia} days");

        $diasRestantes = $hoy->diff($fechaVencimiento)->days;

        // Si ya venció, los días son negativos
        if ($fechaVencimiento < $hoy) {
            return '<span class="badge bg-danger">Vencido</span>';
        } elseif ($diasRestantes <= 7) {
            return '<span class="badge bg-warning">Por vencer (' . $diasRestantes . ' días)</span>';
        } else {
            return '<span class="badge bg-success">Vigente (' . $diasRestantes . ' días)</span>';
        }
    }
}
