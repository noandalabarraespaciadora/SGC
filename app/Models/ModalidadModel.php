<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalidadModel extends Model
{
    protected $table            = 'modalidades';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['modalidad'];

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

    protected $validationRules = [
        'modalidad' => 'required|max_length[255]'
    ];

    protected $validationMessages = [
        'modalidad' => [
            'required' => 'El campo modalidad es obligatorio.',
            'max_length' => 'La modalidad no puede tener más de 255 caracteres.'
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
            'modalidad' => 'required|max_length[255]|is_unique[modalidades.modalidad]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'modalidad' => "required|max_length[255]|is_unique[modalidades.modalidad,id,{$id}]"
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getModalidades()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
                    ->like('modalidad', $term)
                    ->findAll();
    }
}
