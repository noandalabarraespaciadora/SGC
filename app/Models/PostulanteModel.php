<?php

namespace App\Models;

use CodeIgniter\Model;

class PostulanteModel extends Model
{
    protected $table            = 'postulantes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'apellido',
        'nombre',
        'dni',
        'fecha_nacimiento',
        'domicilio',
        'estado_civil',
        'nacionalidad',
        'url_foto',
        'titulo',
        'fecha_titulo',
        'fecha_matriculacion',
        'antiguedad_ejercicio_profesional_letrado',
        'antiguedad_ejercicio_profesional_matriculacion',
        'd_foto_carnet',
        'd_buena_conducta',
        'd_antiguedad',
        'd_sanciones',
        'd_sanciones_descripcion',
        'd_matricula',
        'd_redam',
        'd_rupv',
        'psicofisico',
        'd_certificado_domicilio',
        'd_informacion_sumaria',
        'd_informacion_sumaria_descripcion',
        'estudios_psicofisicos_fecha',
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
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    // Método para obtener postulantes con búsqueda
    public function search($term)
    {
        return $this->select('postulantes.*')
            ->groupStart()
            ->like('apellido', $term)
            ->orLike('nombre', $term)
            ->orLike('dni', $term)
            ->orLike('titulo', $term)
            ->orLike('domicilio', $term)
            ->groupEnd()
            ->orderBy('apellido', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    // Obtener todos los postulantes
    public function getPostulantes()
    {
        return $this->orderBy('apellido', 'ASC')
            ->orderBy('nombre', 'ASC')
            ->findAll();
    }

    // Obtener teléfonos de un postulante
    public function getTelefonos($postulanteId)
    {
        return $this->db->table('postulante_telefonos')
            ->where('postulante_id', $postulanteId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();
    }

    // Obtener emails de un postulante
    public function getEmails($postulanteId)
    {
        return $this->db->table('postulante_emails')
            ->where('postulante_id', $postulanteId)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->getResultArray();
    }

    // Guardar teléfonos
    public function guardarTelefonos($postulanteId, $telefonos)
    {
        if (!empty($telefonos)) {
            foreach ($telefonos as $telefono) {
                if (!empty($telefono)) {
                    $this->db->table('postulante_telefonos')->insert([
                        'postulante_id' => $postulanteId,
                        'numero' => $telefono,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }

    // Guardar emails
    public function guardarEmails($postulanteId, $emails)
    {
        if (!empty($emails)) {
            foreach ($emails as $email) {
                if (!empty($email)) {
                    $this->db->table('postulante_emails')->insert([
                        'postulante_id' => $postulanteId,
                        'direccion' => $email,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
            }
        }
    }

    // Actualizar teléfonos
    public function actualizarTelefonos($postulanteId, $telefonos)
    {
        // Eliminar teléfonos existentes
        $this->db->table('postulante_telefonos')
            ->where('postulante_id', $postulanteId)
            ->delete();

        // Insertar nuevos teléfonos
        $this->guardarTelefonos($postulanteId, $telefonos);
    }

    // Actualizar emails
    public function actualizarEmails($postulanteId, $emails)
    {
        // Eliminar emails existentes
        $this->db->table('postulante_emails')
            ->where('postulante_id', $postulanteId)
            ->delete();

        // Insertar nuevos emails
        $this->guardarEmails($postulanteId, $emails);
    }

    // Eliminar teléfonos
    public function eliminarTelefonos($postulanteId)
    {
        return $this->db->table('postulante_telefonos')
            ->where('postulante_id', $postulanteId)
            ->delete();
    }

    // Eliminar emails
    public function eliminarEmails($postulanteId)
    {
        return $this->db->table('postulante_emails')
            ->where('postulante_id', $postulanteId)
            ->delete();
    }

    // Validar creación
    public function validarCreacion($data)
    {
        // Verificar que el DNI no exista
        $existe = $this->where('dni', $data['dni'])->first();
        if ($existe) {
            $this->errors[] = 'El DNI ya está registrado en el sistema.';
            return false;
        }

        return true;
    }

    // Validar edición
    public function validarEdicion($data, $id)
    {
        // Verificar que el DNI no exista (excluyendo el actual)
        $existe = $this->where('dni', $data['dni'])
            ->where('id !=', $id)
            ->first();
        if ($existe) {
            $this->errors[] = 'El DNI ya está registrado en el sistema.';
            return false;
        }

        return true;
    }

    // Calcular edad a partir de fecha de nacimiento
    public function calcularEdad($fechaNacimiento)
    {
        if (!$fechaNacimiento) return null;

        $nacimiento = new \DateTime($fechaNacimiento);
        $hoy = new \DateTime();
        $edad = $hoy->diff($nacimiento);

        return $edad->y;
    }
}
