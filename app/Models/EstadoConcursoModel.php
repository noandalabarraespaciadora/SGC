<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadoConcursoModel extends Model
{
    protected $table            = 'estado_concursos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['denominacion'];

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
    protected $validationRules = [
        'denominacion' => 'required|max_length[255]'
    ];

    protected $validationMessages = [
        'denominacion' => [
            'required' => 'El campo denominación es obligatorio.',
            'max_length' => 'La denominación no puede tener más de 255 caracteres.'
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
            'denominacion' => 'required|max_length[255]|is_unique[estado_concursos.denominacion,deleted_at,]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'denominacion' => "required|max_length[255]|is_unique[estado_concursos.denominacion,id,{$id},deleted_at,]"
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getEstadoConcursos()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->like('denominacion', $term)
            ->findAll();
    }
}
