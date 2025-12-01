<?php

namespace App\Models;

use CodeIgniter\Model;

class DocenteModel extends Model
{
    protected $table            = 'docentes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'apellido_y_nombre',
        'direccion',
        'url_foto'
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
    protected $validationRules = [
        'apellido_y_nombre' => 'required|max_length[255]',
        'direccion' => 'max_length[500]',
    ];

    protected $validationMessages = [
        'apellido_y_nombre' => [
            'required' => 'El campo apellido y nombre es obligatorio.',
            'max_length' => 'El apellido y nombre no puede tener más de 255 caracteres.'
        ],
        'direccion' => [
            'max_length' => 'La dirección no puede tener más de 500 caracteres.'
        ],
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


    // Métodos de validación
    public function validarCreacion($data)
    {
        $rules = [
            'apellido_y_nombre' => 'required|max_length[255]|is_unique[docentes.apellido_y_nombre,deleted_at,]',
            'direccion' => 'max_length[500]',
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'apellido_y_nombre' => "required|max_length[255]|is_unique[docentes.apellido_y_nombre,id,{$id},deleted_at,]",
            'direccion' => 'max_length[500]',
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    // Métodos para obtener docentes
    public function getDocentes()
    {
        return $this->where('deleted_at', null)
            ->orderBy('apellido_y_nombre', 'ASC')
            ->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->groupStart()
            ->like('apellido_y_nombre', $term)
            ->orLike('direccion', $term)
            ->groupEnd()
            ->orderBy('apellido_y_nombre', 'ASC')
            ->findAll();
    }

    // Métodos para contactos
    public function getEmails($docenteId)
    {
        $emailModel = new DocenteEmailModel();
        return $emailModel->where('id_persona', $docenteId)->findAll();
    }

    public function getTelefonos($docenteId)
    {
        $telefonoModel = new DocenteTelefonoModel();
        return $telefonoModel->where('id_persona', $docenteId)->findAll();
    }

    // Métodos públicos para manejar contactos
    public function guardarEmails($docenteId, $emails)
    {
        if ($emails) {
            $emailModel = new DocenteEmailModel();
            foreach ($emails as $email) {
                if (!empty(trim($email))) {
                    $emailModel->insert([
                        'id_persona' => $docenteId,
                        'direccion' => trim($email)
                    ]);
                }
            }
        }
    }

    public function guardarTelefonos($docenteId, $telefonos)
    {
        if ($telefonos) {
            $telefonoModel = new DocenteTelefonoModel();
            foreach ($telefonos as $telefono) {
                if (!empty(trim($telefono))) {
                    $telefonoModel->insert([
                        'id_persona' => $docenteId,
                        'numero' => trim($telefono)
                    ]);
                }
            }
        }
    }

    public function actualizarEmails($docenteId, $emails)
    {
        $emailModel = new DocenteEmailModel();
        $emailModel->where('id_persona', $docenteId)->delete();
        $this->guardarEmails($docenteId, $emails);
    }

    public function actualizarTelefonos($docenteId, $telefonos)
    {
        $telefonoModel = new DocenteTelefonoModel();
        $telefonoModel->where('id_persona', $docenteId)->delete();
        $this->guardarTelefonos($docenteId, $telefonos);
    }

    public function eliminarEmails($docenteId)
    {
        $emailModel = new DocenteEmailModel();
        $emailModel->where('id_persona', $docenteId)->delete();
    }

    public function eliminarTelefonos($docenteId)
    {
        $telefonoModel = new DocenteTelefonoModel();
        $telefonoModel->where('id_persona', $docenteId)->delete();
    }
}
