<?php

namespace App\Models;

use CodeIgniter\Model;

class ConcursoModel extends Model
{
    protected $table            = 'concursos';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'numero_expediente',
        'caratula',
        'resolucionSTJ',
        'comunicacionCM',
        'fecha_edicto_publicacion',
        'fecha_escrito',
        'fecha_oral',
        'propuestas_nro_oficio',
        'propuestas_fecha',
        'resultadoVotacion',
        'observaciones',
        'id_unificado',
        'id_estado_concurso'
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
        'numero_expediente' => 'required|max_length[50]',
        'caratula' => 'max_length[5000]',
        'resolucionSTJ' => 'max_length[100]',
        'comunicacionCM' => 'max_length[100]',
        'propuestas_nro_oficio' => 'max_length[100]',
        'resultadoVotacion' => 'max_length[255]',
    ];

    protected $validationMessages = [
        'numero_expediente' => [
            'required' => 'El número de expediente es obligatorio.',
            'max_length' => 'El número de expediente no puede tener más de 50 caracteres.'
        ],
        'caratula' => [
            'max_length' => 'La carátula no puede tener más de 5000 caracteres.'
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



    // Métodos para validaciones específicas
    public function validarCreacion($data)
    {
        $rules = [
            'numero_expediente' => 'required|max_length[50]|is_unique[concursos.numero_expediente,deleted_at,]',
            'caratula' => 'max_length[5000]',
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'numero_expediente' => "required|max_length[50]|is_unique[concursos.numero_expediente,id,{$id},deleted_at,]",
            'caratula' => 'max_length[5000]',
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    // En el método getConcursos() de ConcursoModel
    public function getConcursos()
    {
        return $this->select('concursos.*, estado_concursos.denominacion as estado_denominacion, unificado.denominacion as unificado_nombre')
            ->join('estado_concursos', 'estado_concursos.id = concursos.id_estado_concurso', 'left')
            ->join('unificado', 'unificado.id = concursos.id_unificado', 'left')
            ->where('concursos.deleted_at', null)
            ->orderBy('concursos.numero_expediente', 'ASC')
            ->findAll();
    }

    public function search($term)
    {
        return $this->select('concursos.*, estado_concursos.denominacion as estado_denominacion, unificado.denominacion as unificado_denominacion')
            ->join('estado_concursos', 'estado_concursos.id = concursos.id_estado_concurso', 'left')
            ->join('unificado', 'unificado.id = concursos.id_unificado', 'left')
            ->where('concursos.deleted_at', null)
            ->groupStart()
            ->like('concursos.numero_expediente', $term)
            ->orLike('concursos.caratula', $term)
            ->orLike('concursos.resolucionSTJ', $term)
            ->orLike('estado_concursos.denominacion', $term)
            ->groupEnd()
            ->orderBy('concursos.numero_expediente', 'ASC')
            ->findAll();
    }

    // Métodos para obtener relaciones
    public function getComision($concursoId)
    {
        $db = db_connect();
        return $db->table('docentes_x_concursos')
            ->select('docentes_x_concursos.*, docentes.apellido_y_nombre as docente_nombre, representaciones.representacion as representacion_nombre')
            ->join('docentes', 'docentes.id = docentes_x_concursos.id_docente', 'left')
            ->join('representaciones', 'representaciones.id = docentes_x_concursos.id_representacion', 'left')
            ->where('id_concurso', $concursoId)
            ->orderBy('docentes_x_concursos.condicion', 'ASC')
            ->orderBy('docentes.apellido_y_nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getPostulantes($concursoId)
    {
        $db = db_connect();
        return $db->table('postulantes_x_concursos')
            ->select('postulantes_x_concursos.*, niveles_excelencia.nivel as nivel_codigo, niveles_excelencia.nivel as nivel_nombre')
            ->join('niveles_excelencia', 'niveles_excelencia.id = postulantes_x_concursos.id_nivel', 'left')
            ->where('id_concurso', $concursoId)
            ->orderBy('niveles_excelencia.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    // Métodos para manejar relaciones
    public function guardarComision($concursoId, $comision)
    {
        if ($comision) {
            $db = db_connect();
            foreach ($comision as $miembro) {
                if (!empty($miembro['id_docente'])) {
                    $db->table('docentes_x_concursos')->insert([
                        'id_concurso' => $concursoId,
                        'id_docente' => $miembro['id_docente'],
                        'id_representacion' => $miembro['id_representacion'] ?? null,
                        'condicion' => $miembro['condicion'] ?? 'titular'
                    ]);
                }
            }
        }
    }

    public function actualizarComision($concursoId, $comision)
    {
        $db = db_connect();
        $db->table('docentes_x_concursos')->where('id_concurso', $concursoId)->delete();
        $this->guardarComision($concursoId, $comision);
    }

    public function eliminarComision($concursoId)
    {
        $db = db_connect();
        $db->table('docentes_x_concursos')->where('id_concurso', $concursoId)->delete();
    }

    // Métodos para estadísticas
    public function getEstadisticas($concursoId)
    {
        $db = db_connect();

        $postulantes = $this->getPostulantes($concursoId);
        $comision = $this->getComision($concursoId);

        $estadisticas = [
            'total_postulantes' => count($postulantes),
            'total_comision' => count($comision),
            'titulares' => 0,
            'suplentes' => 0,
            'por_nivel' => []
        ];

        foreach ($comision as $miembro) {
            if (strtolower($miembro['condicion']) === 'titular') {
                $estadisticas['titulares']++;
            } elseif (strtolower($miembro['condicion']) === 'suplente') {
                $estadisticas['suplentes']++;
            }
        }

        foreach ($postulantes as $postulante) {
            $nivel = $postulante['nivel_codigo'] ?? 'SIN_NIVEL';
            if (!isset($estadisticas['por_nivel'][$nivel])) {
                $estadisticas['por_nivel'][$nivel] = 0;
            }
            $estadisticas['por_nivel'][$nivel]++;
        }

        return $estadisticas;
    }
}
