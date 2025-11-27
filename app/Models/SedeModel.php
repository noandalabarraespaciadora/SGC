<?php

namespace App\Models;

use CodeIgniter\Model;

class SedeModel extends Model
{
    protected $table            = 'sedes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['denominacion', 'direccion', 'email', 'telefono'];

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
        'denominacion' => 'required|max_length[255]',
        'direccion' => 'max_length[500]',
        'email' => 'max_length[100]|valid_email',
        'telefono' => 'max_length[50]'
    ];
    protected $validationMessages = [
        'denominacion' => [
            'required' => 'El campo denominación es obligatorio.',
            'max_length' => 'La denominación no puede tener más de 255 caracteres.'
        ],
        'direccion' => [
            'max_length' => 'La dirección no puede tener más de 500 caracteres.'
        ],
        'email' => [
            'max_length' => 'El email no puede tener más de 100 caracteres.',
            'valid_email' => 'El formato del email no es válido.'
        ],
        'telefono' => [
            'max_length' => 'El teléfono no puede tener más de 50 caracteres.'
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
            'denominacion' => 'required|max_length[255]|is_unique[sedes.denominacion]',
            'direccion' => 'max_length[500]',
            'email' => 'max_length[100]|valid_email',
            'telefono' => 'max_length[50]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'denominacion' => "required|max_length[255]|is_unique[sedes.denominacion,id,{$id}]",
            'direccion' => 'max_length[500]',
            'email' => 'max_length[100]|valid_email',
            'telefono' => 'max_length[50]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getSedes()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
                    ->groupStart()
                    ->like('denominacion', $term)
                    ->orLike('direccion', $term)
                    ->orLike('email', $term)
                    ->orLike('telefono', $term)
                    ->groupEnd()
                    ->findAll();
    }
}
