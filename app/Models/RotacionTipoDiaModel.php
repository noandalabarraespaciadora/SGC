<?php

namespace App\Models;

use CodeIgniter\Model;

class RotacionTipoDiaModel extends Model
{
    protected $table            = 'rotacion_tipos_dia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nombre',
        'color',
        'descripcion',
        'requiere_acuerdo',
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
        'nombre' => 'required|min_length[2]|max_length[100]|is_unique[rotacion_tipos_dia.nombre,id,{id}]',
        'color' => 'required|regex_match[/^#[a-fA-F0-9]{6}$/]',
        'requiere_acuerdo' => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'color' => [
            'regex_match' => 'El color debe ser un código hexadecimal válido (ej: #FF0000)'
        ]
    ];

    /**
     * Obtiene tipos de día activos ordenados
     */
    public function getTiposActivos()
    {
        return $this->where('activo', 1)
            ->orderBy('orden', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    /**
     * Obtiene tipos de día que requieren acuerdo
     */
    public function getTiposConAcuerdo()
    {
        return $this->where('activo', 1)
            ->where('requiere_acuerdo', 1)
            ->findAll();
    }


    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
