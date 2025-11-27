<?php

namespace App\Models;

use CodeIgniter\Model;

class RepresentacionModel extends Model
{
    protected $table            = 'representaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['representacion'];

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
        'representacion' => 'required|max_length[255]'
    ];
    protected $validationMessages = [
        'representacion' => [
            'required' => 'El campo representación es obligatorio.',
            'max_length' => 'La representación no puede tener más de 255 caracteres.'
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
            'representacion' => 'required|max_length[255]|is_unique[representaciones.representacion,deleted_at,]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'representacion' => "required|max_length[255]|is_unique[representaciones.representacion,id,{$id},deleted_at,]"
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getRepresentaciones()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->like('representacion', $term)
            ->findAll();
    }
}
