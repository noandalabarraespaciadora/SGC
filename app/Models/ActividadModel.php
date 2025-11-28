<?php

namespace App\Models;

use CodeIgniter\Model;

class ActividadModel extends Model
{
    protected $table            = 'actividades';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'titulo',
        'fecha',
        'hora',
        'duracion',
        'id_sede',
        'id_modalidad',
        'id_tipo_actividad',
        'descripcion'
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

    // Validation
    protected $validationRules = [
        'titulo' => 'required|min_length[3]|max_length[255]',
        'fecha' => 'permit_empty',
        'hora' => 'permit_empty',
        'duracion' => 'permit_empty|integer|greater_than[0]',
        'id_sede' => 'permit_empty|integer',
        'id_modalidad' => 'permit_empty|integer',
        'id_tipo_actividad' => 'permit_empty|integer',
        'descripcion' => 'permit_empty'
    ];

    protected $validationMessages = [
        'titulo' => [
            'required' => 'El título es obligatorio.',
            'min_length' => 'El título debe tener al menos 3 caracteres.',
            'max_length' => 'El título no puede exceder los 255 caracteres.',
        ],
        'fecha' => [
            'valid_date' => 'La fecha debe ser una fecha válida.'
        ],
        'hora' => [
            'valid_time' => 'La hora debe ser una hora válida.'
        ],
        'duracion' => [
            'integer' => 'La duración debe ser un número entero.',
            'greater_than' => 'La duración debe ser mayor a 0.'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Obtener actividades con relaciones
     */
    public function getActividades()
    {
        return $this->select('actividades.*, 
                             sedes.denominacion as sede_nombre,
                             modalidades.modalidad as modalidad_nombre,
                             tipo_actividades.actividad as tipo_actividad_nombre')
            ->join('sedes', 'sedes.id = actividades.id_sede', 'left')
            ->join('modalidades', 'modalidades.id = actividades.id_modalidad', 'left')
            ->join('tipo_actividades', 'tipo_actividades.id = actividades.id_tipo_actividad', 'left')
            ->orderBy('actividades.fecha', 'DESC')
            ->orderBy('actividades.hora', 'DESC')
            ->findAll();
    }

    /**
     * Obtener actividades para calendario
     */
    public function getActividadesCalendario($startDate = null, $endDate = null)
    {
        $builder = $this->select('actividades.*, 
                                 sedes.denominacion as sede_nombre,
                                 modalidades.modalidad as modalidad_nombre,
                                 tipo_actividades.actividad as tipo_actividad_nombre,
                                 tipo_actividades.color as tipo_color')
            ->join('sedes', 'sedes.id = actividades.id_sede', 'left')
            ->join('modalidades', 'modalidades.id = actividades.id_modalidad', 'left')
            ->join('tipo_actividades', 'tipo_actividades.id = actividades.id_tipo_actividad', 'left');

        if ($startDate && $endDate) {
            $builder->where('actividades.fecha >=', $startDate)
                ->where('actividades.fecha <=', $endDate);
        }

        return $builder->orderBy('actividades.fecha', 'ASC')
            ->orderBy('actividades.hora', 'ASC')
            ->findAll();
    }

    /**
     * Buscar actividades
     */
    public function search($search)
    {
        return $this->select('actividades.*, 
                             sedes.denominacion as sede_nombre,
                             modalidades.modalidad as modalidad_nombre,
                             tipo_actividades.actividad as tipo_actividad_nombre')
            ->join('sedes', 'sedes.id = actividades.id_sede', 'left')
            ->join('modalidades', 'modalidades.id = actividades.id_modalidad', 'left')
            ->join('tipo_actividades', 'tipo_actividades.id = actividades.id_tipo_actividad', 'left')
            ->groupStart()
            ->like('actividades.titulo', $search)
            ->orLike('actividades.descripcion', $search)
            ->orLike('sedes.denominacion', $search)
            ->orLike('modalidades.modalidad', $search)
            ->orLike('tipo_actividades.actividad', $search)
            ->groupEnd()
            ->orderBy('actividades.fecha', 'DESC')
            ->orderBy('actividades.hora', 'DESC')
            ->findAll();
    }

    /**
     * Validación para creación
     */
    public function validarCreacion($data)
    {
        $rules = $this->validationRules;

        // Agregar regla personalizada para verificar unicidad ignorando eliminados
        $rules['titulo'] = [
            'label' => 'Título',
            'rules' => [
                'required',
                'min_length[3]',
                'max_length[255]',
                function ($value, $data, &$error, $field) {
                    $model = new ActividadModel();
                    $exists = $model->where('titulo', $value)->first();

                    if ($exists) {
                        $error = 'Ya existe una actividad con este título.';
                        return false;
                    }
                    return true;
                }
            ]
        ];

        $this->validationRules = $rules;

        return $this->validate($data);
    }



    /**
     * Validación para edición
     */
    public function validarEdicion($data, $id)
    {
        $rules = $this->validationRules;

        // Agregar regla personalizada para verificar unicidad ignorando eliminados y el registro actual
        $rules['titulo'] = [
            'label' => 'Título',
            'rules' => [
                'required',
                'min_length[3]',
                'max_length[255]',
                function ($value, $data, &$error, $field) use ($id) {
                    $model = new ActividadModel();
                    $exists = $model->where('titulo', $value)
                        ->where('id !=', $id)
                        ->first();

                    if ($exists) {
                        $error = 'Ya existe una actividad con este título.';
                        return false;
                    }
                    return true;
                }
            ]
        ];

        // Asignar las reglas al modelo para que update() las use
        $this->validationRules = $rules;

        // Ejecutar validación usando el mecanismo del modelo
        return $this->validate($data);
    }
}
