<?php

namespace App\Controllers;


use App\Models\PostulanteModel;
use App\Models\DocenteModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SearchController extends BaseController
{
    protected $postulanteModel;
    protected $docenteModel;
    protected $data = [];

    public function __construct()
    {
        $this->postulanteModel = new PostulanteModel();
        $this->docenteModel = new DocenteModel();

        $this->data = [
            'usuario_nombre' => session()->get('usuario_nombre'),
            'usuario_apellido' => session()->get('usuario_apellido'),
            'usuario_alias' => session()->get('usuario_alias'),
            'usuario_rol' => session()->get('usuario_rol'),
            'usuario_mensaje_estado' => session()->get('usuario_mensaje_estado')
        ];
    }

    /**
     * Muestra la página principal de búsqueda
     */
    public function index()
    {
        $searchTerm = $this->request->getGet('q');

        $data = array_merge($this->data, [
            'title' => 'Búsqueda - SGC',
            'searchTerm' => $searchTerm,
            'results' => [],
            'totalResults' => 0
        ]);

        return view('search/index', $data);
    }

    /**
     * Realiza la búsqueda y devuelve resultados en JSON para AJAX
     */
    public function search()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->to('/buscar');
        }

        $searchTerm = $this->request->getGet('q');

        if (empty($searchTerm)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ingrese un término de búsqueda',
                'results' => [],
                'total' => 0
            ]);
        }

        $postulantes = [];
        $docentes = [];

        // Buscar en postulantes
        if (!empty($searchTerm)) {
            $postulantes = $this->postulanteModel->search($searchTerm);

            // Calcular edad y obtener contactos para cada postulante
            foreach ($postulantes as &$postulante) {
                $postulante['telefonos'] = $this->postulanteModel->getTelefonos($postulante['id']);
                $postulante['emails'] = $this->postulanteModel->getEmails($postulante['id']);
                $postulante['edad'] = $this->postulanteModel->calcularEdad($postulante['fecha_nacimiento']);
                $postulante['tipo'] = 'postulante';
            }
        }

        // Buscar en docentes
        if (!empty($searchTerm)) {
            $docentes = $this->docenteModel->search($searchTerm);

            // Obtener contactos para cada docente
            foreach ($docentes as &$docente) {
                $docente['emails'] = $this->docenteModel->getEmails($docente['id']);
                $docente['telefonos'] = $this->docenteModel->getTelefonos($docente['id']);
                $docente['tipo'] = 'docente';
            }
        }

        // Combinar resultados
        $allResults = array_merge($postulantes, $docentes);

        // Ordenar por apellido y nombre
        usort($allResults, function ($a, $b) {
            if ($a['tipo'] === 'postulante' && isset($a['apellido'])) {
                $aNombre = $a['apellido'] . ' ' . $a['nombre'];
                $bNombre = isset($b['apellido']) ? $b['apellido'] . ' ' . $b['nombre'] : $b['apellido_y_nombre'];
            } else {
                $aNombre = isset($a['apellido_y_nombre']) ? $a['apellido_y_nombre'] : '';
                $bNombre = isset($b['apellido_y_nombre']) ? $b['apellido_y_nombre'] : '';
            }
            return strcasecmp($aNombre, $bNombre);
        });

        return $this->response->setJSON([
            'success' => true,
            'results' => $allResults,
            'total' => count($allResults),
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Calcula el estado de documentación de un postulante
     */
    private function calcularEstadoDocumentacion($postulante)
    {
        // Aquí implementas la lógica para determinar el estado
        // Basado en los campos d_* (documentos)

        $documentosCompletos = 0;
        $documentosTotales = 0;

        // Verificar documentos básicos (ejemplo)
        $camposDocumentos = [
            'd_foto_carnet',
            'd_buena_conducta',
            'd_antiguedad',
            'd_matricula',
            'd_redam',
            'd_rupv',
            'd_certificado_domicilio',
            'd_informacion_sumaria'
        ];

        foreach ($camposDocumentos as $campo) {
            $documentosTotales++;
            if (!empty($postulante[$campo])) {
                $documentosCompletos++;
            }
        }

        if ($documentosTotales === 0) return ['estado' => 'sin-datos', 'progreso' => 0];

        $progreso = round(($documentosCompletos / $documentosTotales) * 100);

        if ($progreso === 100) {
            $estado = 'completo';
        } elseif ($progreso >= 70) {
            $estado = 'incompleto';
        } else {
            $estado = 'vencido'; // O 'incompleto-severo'
        }

        return [
            'estado' => $estado,
            'progreso' => $progreso,
            'completos' => $documentosCompletos,
            'totales' => $documentosTotales
        ];
    }
}
