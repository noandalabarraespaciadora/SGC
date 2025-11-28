<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoActividadModel extends Model
{
    protected $table            = 'tipo_actividades';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['actividad', 'color'];

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
        'actividad' => 'required|max_length[255]',
        'color' => 'required|max_length[7]'
    ];
    protected $validationMessages = [
        'actividad' => [
            'required' => 'El campo actividad es obligatorio.',
            'max_length' => 'La actividad no puede tener más de 255 caracteres.'
        ],
        'color' => [
            'required' => 'El campo color es obligatorio.',
            'max_length' => 'El color no puede tener más de 7 caracteres.'
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
            'actividad' => 'required|max_length[255]',
            'color'     => 'required|max_length[7]'
        ];

        if (!$this->validate($data, $rules)) {
            return false;
        }

        // Verificar unicidad sin contar eliminados
        $existe = $this->where('actividad', $data['actividad'])
            ->where('deleted_at', null)
            ->first();

        if ($existe) {
            $this->setError('actividad', 'El nombre de la actividad ya existe.');
            return false;
        }

        return true;
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'actividad' => 'required|max_length[255]',
            'color'     => 'required|max_length[7]'
        ];

        if (!$this->validate($data, $rules)) {
            return false;
        }

        // Verificar unicidad excluyendo el propio registro y los eliminados
        $existe = $this->where('actividad', $data['actividad'])
            ->where('id !=', $id)
            ->where('deleted_at', null)
            ->first();

        if ($existe) {
            $this->seterror('actividad', 'El nombre de la actividad ya existe.');
            return false;
        }

        return true;
    }

    public function getTipoActividades()
    {
        return $this->where('deleted_at', null)->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->like('actividad', $term)
            ->findAll();
    }
}
