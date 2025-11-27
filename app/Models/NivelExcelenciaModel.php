<?php

namespace App\Models;

use CodeIgniter\Model;

class NivelExcelenciaModel extends Model
{
    protected $table            = 'niveles_excelencia';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nivel', 'abreviatura'];

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

    // Validation - SIN reglas de unicidad aquí
    protected $validationRules = [
        'nivel' => 'required|max_length[255]',
        'abreviatura' => 'required|max_length[50]'
    ];

    protected $validationMessages = [
        'nivel' => [
            'required' => 'El campo nivel es obligatorio.',
            'max_length' => 'El nivel no puede tener más de 255 caracteres.'
        ],
        'abreviatura' => [
            'required' => 'El campo abreviatura es obligatorio.',
            'max_length' => 'La abreviatura no puede tener más de 50 caracteres.'
        ]
    ];
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

    public function validarCreacion($data)
    {
        $rules = [
            'nivel' => 'required|max_length[255]|is_unique[niveles_excelencia.nivel,deleted_at,]',
            'abreviatura' => 'required|max_length[50]|is_unique[niveles_excelencia.abreviatura,deleted_at,]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'nivel' => "required|max_length[255]|is_unique[niveles_excelencia.nivel,id,{$id},deleted_at,]",
            'abreviatura' => "required|max_length[50]|is_unique[niveles_excelencia.abreviatura,id,{$id},deleted_at,]"
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getNiveles()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->groupStart()
            ->like('nivel', $term)
            ->orLike('abreviatura', $term)
            ->groupEnd()
            ->findAll();
    }
}
