<?php

namespace App\Models;

use CodeIgniter\Model;

class RotacionModel extends Model
{
    protected $table            = 'rotaciones';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'fecha',
        'tipo_dia_id',
        'numero_acuerdo',
        'observaciones',
        'created_by',
        'updated_by'
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

    // Relaciones
    protected $with = ['tipoDia', 'personal'];

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

    /**
     * Obtiene el tipo de día relacionado
     */
    protected function getTipoDia(array $row)
    {
        $tipoDiaModel = new RotacionTipoDiaModel();
        return $tipoDiaModel->find($row['tipo_dia_id']);
    }

    /**
     * Obtiene el personal asignado a la rotación
     */
    protected function getPersonal(array $row)
    {
        $db = db_connect();
        return $db->table('rotacion_detalles det')
            ->select('per.*')
            ->join('rotacion_personal per', 'per.id = det.personal_id')
            ->where('det.rotacion_id', $row['id'])
            ->orderBy('per.categoria', 'DESC') // Jerárquicos primero
            ->orderBy('per.apellido', 'ASC')
            ->orderBy('per.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene rotaciones por rango de fechas
     */
    public function getPorRango($fechaInicio, $fechaFin)
    {
        $rotaciones = $this->where('fecha >=', $fechaInicio)
            ->where('fecha <=', $fechaFin)
            ->orderBy('fecha', 'ASC')
            ->findAll();

        // Cargar personal para cada rotación
        foreach ($rotaciones as &$rotacion) {
            $rotacion['personal'] = $this->getPersonalPorRotacion($rotacion['id']);
        }

        return $rotaciones;
    }

    /**
     * Obtiene rotación por fecha exacta
     */
    public function getPorFecha($fecha)
    {
        return $this->where('fecha', $fecha)->first();
    }

    /**
     * Obtiene el personal asignado a una rotación específica
     */
    public function getPersonalPorRotacion($rotacionId)
    {
        $db = db_connect();
        return $db->table('rotacion_detalles det')
            ->select('per.*')
            ->join('rotacion_personal per', 'per.id = det.personal_id')
            ->where('det.rotacion_id', $rotacionId)
            ->orderBy('per.categoria', 'DESC') // Jerárquicos primero
            ->orderBy('per.apellido', 'ASC')
            ->orderBy('per.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Asigna personal a una rotación
     */
    public function asignarPersonal($rotacionId, array $personalIds)
    {
        $db = db_connect();

        // Eliminar asignaciones anteriores
        $db->table('rotacion_detalles')
            ->where('rotacion_id', $rotacionId)
            ->delete();

        // Insertar nuevas asignaciones
        if (!empty($personalIds)) {
            $data = [];
            foreach ($personalIds as $personalId) {
                $data[] = [
                    'rotacion_id' => $rotacionId,
                    'personal_id' => $personalId,
                    'created_at' => date('Y-m-d H:i:s')
                ];
            }

            $db->table('rotacion_detalles')->insertBatch($data);
        }

        return true;
    }

    /**
     * Valida que se cumplan las reglas básicas
     */
    public function validarAsignacion($fecha, $tipoDiaId, $personalIds)
    {
        $errors = [];

        // Verificar que la fecha no sea fin de semana
        $diaSemana = date('w', strtotime($fecha));
        if ($diaSemana == 0 || $diaSemana == 6) {
            $errors[] = 'No se pueden asignar rotaciones para fines de semana';
        }

        // Verificar que no haya duplicados para la misma fecha
        $existente = $this->getPorFecha($fecha);
        if ($existente && (!isset($this->id) || $existente['id'] != $this->id)) {
            $errors[] = 'Ya existe una rotación para esta fecha';
        }

        return $errors;
    }

    /**
     * Obtiene estadísticas por mes
     */
    public function getEstadisticasMes($mes, $anio)
    {
        $db = db_connect();

        // Obtener días laborables del mes (lunes a viernes)
        $primerDia = date('Y-m-01', strtotime("$anio-$mes-01"));
        $ultimoDia = date('Y-m-t', strtotime("$anio-$mes-01"));

        return $db->table($this->table . ' r')
            ->select('COUNT(r.id) as total_dias, td.nombre as tipo_dia, td.color')
            ->join('rotacion_tipos_dia td', 'td.id = r.tipo_dia_id', 'left')
            ->where('r.fecha >=', $primerDia)
            ->where('r.fecha <=', $ultimoDia)
            ->groupBy('r.tipo_dia_id, td.nombre, td.color')
            ->orderBy('total_dias', 'DESC')
            ->get()
            ->getResultArray();
    }
}
