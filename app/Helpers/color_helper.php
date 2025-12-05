<?php

if (!function_exists('get_contrast_color')) {
    /**
     * Calcula el color de texto (blanco o negro) que mejor contrasta con el fondo
     *
     * @param string $hexColor Color en formato hexadecimal (ej: #FF0000)
     * @return string '#000000' o '#FFFFFF'
     */
    function get_contrast_color($hexColor)
    {
        // Eliminar # si existe
        $hexColor = ltrim($hexColor, '#');

        // Si es corto (3 chars), expandir
        if (strlen($hexColor) === 3) {
            $hexColor = $hexColor[0] . $hexColor[0] . $hexColor[1] . $hexColor[1] . $hexColor[2] . $hexColor[2];
        }

        // Convertir a RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));

        // Calcular luminancia (fórmula estándar)
        $yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return ($yiq >= 128) ? '#000000' : '#FFFFFF';
    }
}

if (!function_exists('get_avatar_color')) {
    /**
     * Genera un color único para el avatar basado en el nombre
     *
     * @param string $nombreCompleto
     * @return string
     */
    function get_avatar_color($nombreCompleto)
    {
        // Lista de 12 colores atractivos
        $colores = [
            '#FF6B6B',
            '#4ECDC4',
            '#45B7D1',
            '#96CEB4',
            '#FFEAA7',
            '#DDA0DD',
            '#98D8C8',
            '#F7DC6F',
            '#BB8FCE',
            '#85C1E9',
            '#F8C471',
            '#82E0AA'
        ];

        $hash = crc32($nombreCompleto);
        $indice = abs($hash) % count($colores);

        return $colores[$indice];
    }
}
