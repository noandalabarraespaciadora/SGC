<?php

namespace App\Models;

use CodeIgniter\Model;

class RotacionPersonalModel extends Model
{
    protected $table            = 'rotacion_personal';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'apellido',
        'categoria',
        'area',
        'url_foto',
        'activo',
        'orden'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    // Validación
    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
        'apellido' => 'required|min_length[2]|max_length[100]',
        'categoria' => 'required|in_list[jerarquico,no_jerarquico]',
        'area' => 'permit_empty|max_length[100]',
    ];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    // Callbacks
    protected $beforeInsert = ['generarIniciales'];
    protected $afterInsert    = [];
    protected $beforeUpdate = ['generarIniciales'];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Genera las iniciales para avatar si no hay foto
     */
    protected function generarIniciales(array $data)
    {
        if (!isset($data['data']['url_foto']) || empty($data['data']['url_foto'])) {
            $nombre = $data['data']['nombre'] ?? '';
            $apellido = $data['data']['apellido'] ?? '';

            if (!empty($nombre) && !empty($apellido)) {
                $iniciales = strtoupper(substr($nombre, 0, 1) . substr($apellido, 0, 1));
                // Esto se usará en la vista para generar el avatar con color
            }
        }

        return $data;
    }

    /**
     * Obtiene todo el personal activo ordenado
     */
    public function getPersonalActivo()
    {
        return $this->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->orderBy('apellido', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    /**
     * Obtiene personal por categoría
     */
    public function getPorCategoria($categoria)
    {
        return $this->where('activo', 1)
            ->where('categoria', $categoria)
            ->orderBy('orden', 'ASC')
            ->orderBy('apellido', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    /**
     * Obtiene jerárquicos activos
     */
    public function getJerarquicos()
    {
        return $this->getPorCategoria('jerarquico');
    }

    /**
     * Obtiene no jerárquicos activos
     */
    public function getNoJerarquicos()
    {
        return $this->getPorCategoria('no_jerarquico');
    }

    /**
     * Genera un color único para el avatar basado en el nombre
     */
    public function generarColorAvatar($nombreCompleto)
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
