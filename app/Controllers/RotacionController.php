<?php

namespace App\Controllers;

use App\Models\RotacionModel;
use App\Controllers\BaseController;
use App\Models\RotacionTipoDiaModel;
use App\Models\RotacionPersonalModel;
use CodeIgniter\HTTP\ResponseInterface;

class RotacionController extends BaseController
{
    protected $personalModel;
    protected $tipoDiaModel;
    protected $rotacionModel;
    protected $data = [];

    public function __construct()
    {
        helper(['color']);
        $this->personalModel = new RotacionPersonalModel();
        $this->tipoDiaModel = new RotacionTipoDiaModel();
        $this->rotacionModel = new RotacionModel();

        $this->data = [
            'usuario_nombre' => session()->get('usuario_nombre'),
            'usuario_apellido' => session()->get('usuario_apellido'),
            'usuario_alias' => session()->get('usuario_alias'),
            'usuario_rol' => session()->get('usuario_rol'),
            'usuario_mensaje_estado' => session()->get('usuario_mensaje_estado')
        ];
    }

    /**
     * Vista principal - Calendario
     */
    public function index()
    {
        $view = $this->request->getGet('view') ?? 'semanal';
        $fecha = $this->request->getGet('fecha') ?? date('Y-m-d');

        $data = array_merge($this->data, [
            'title' => 'Rotación de Personal - SGC',
            'view' => $view,
            'fecha_actual' => $fecha,
            'personal' => $this->personalModel->getPersonalActivo(),
            'tipos_dia' => $this->tipoDiaModel->getTiposActivos(),
        ]);

        // Obtener rotaciones según la vista
        if ($view === 'semanal') {
            // Calcular semana (lunes a viernes)
            $fechaObj = new \DateTime($fecha);
            $inicioSemana = clone $fechaObj;
            $inicioSemana->modify('monday this week');
            $finSemana = clone $inicioSemana;
            $finSemana->modify('friday this week');

            $data['rotaciones'] = $this->rotacionModel->getPorRango(
                $inicioSemana->format('Y-m-d'),
                $finSemana->format('Y-m-d')
            );
            $data['inicio_semana'] = $inicioSemana->format('Y-m-d');
            $data['fin_semana'] = $finSemana->format('Y-m-d');
        } else {
            // Vista mensual
            $fechaObj = new \DateTime($fecha);
            $inicioMes = $fechaObj->format('Y-m-01');
            $finMes = $fechaObj->format('Y-m-t');

            $data['rotaciones'] = $this->rotacionModel->getPorRango($inicioMes, $finMes);
            $data['mes_actual'] = $fechaObj->format('Y-m');
        }

        return view('rotacion/index', $data);
    }

    /**
     * Guardar/Actualizar rotación
     */
    public function guardar()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $fecha = $this->request->getPost('fecha');
        $tipoDiaId = $this->request->getPost('tipo_dia_id');
        $numeroAcuerdo = $this->request->getPost('numero_acuerdo');
        $personalIds = $this->request->getPost('personal_ids') ?? [];
        $observaciones = $this->request->getPost('observaciones');

        // Validar
        $errors = $this->rotacionModel->validarAsignacion($fecha, $tipoDiaId, $personalIds);
        if (!empty($errors)) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        // Verificar si ya existe
        $existente = $this->rotacionModel->getPorFecha($fecha);

        $data = [
            'fecha' => $fecha,
            'tipo_dia_id' => $tipoDiaId ?: null,
            'numero_acuerdo' => $numeroAcuerdo,
            'observaciones' => $observaciones,
            'updated_by' => session()->get('usuario_id')
        ];

        if ($existente) {
            // Actualizar
            $this->rotacionModel->update($existente['id'], $data);
            $rotacionId = $existente['id'];
        } else {
            // Crear nuevo
            $data['created_by'] = session()->get('usuario_id');
            $this->rotacionModel->insert($data);
            $rotacionId = $this->rotacionModel->getInsertID();
        }

        // Asignar personal
        $this->rotacionModel->asignarPersonal($rotacionId, $personalIds);

        return redirect()->to('/rotacion')->with('success', 'Rotación guardada correctamente.');
    }

    /**
     * Eliminar rotación
     */
    public function eliminar($fecha)
    {
        $rotacion = $this->rotacionModel->getPorFecha($fecha);

        if (!$rotacion) {
            return redirect()->back()->with('error', 'No se encontró la rotación.');
        }

        if ($this->rotacionModel->delete($rotacion['id'])) {
            return redirect()->to('/rotacion')->with('success', 'Rotación eliminada correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la rotación.');
    }

    /**
     * API: Obtener rotación por fecha (para AJAX)
     */
    public function apiGetPorFecha($fecha)
    {
        $rotacion = $this->rotacionModel->getPorFecha($fecha);

        if ($rotacion) {
            // Obtener IDs del personal asignado
            $personalIds = array_column($rotacion['personal'], 'id');
            $rotacion['personal_ids'] = $personalIds;
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $rotacion
        ]);
    }

    /**
     * API: Obtener personal disponible
     */
    public function apiGetPersonal()
    {
        $personal = $this->personalModel->getPersonalActivo();

        // Agregar color para avatar
        foreach ($personal as &$persona) {
            $persona['color_avatar'] = $this->personalModel->generarColorAvatar(
                $persona['nombre'] . ' ' . $persona['apellido']
            );
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $personal
        ]);
    }

    /**
     * Gestión de Personal
     */
    public function personal()
    {
        $data = array_merge($this->data, [
            'title' => 'Gestión de Personal - Rotación',
            'personal' => $this->personalModel->getPersonalActivo(),
        ]);

        return view('rotacion/personal/index', $data);
    }

    /**
     * Crear/Editar Personal
     */
    public function guardarPersonal()
    {
        // Similar a PostulantesController
    }

    /**
     * Gestión de Tipos de Día
     */
    public function tiposDia()
    {
        $data = array_merge($this->data, [
            'title' => 'Tipos de Día - Rotación',
            'tipos_dia' => $this->tipoDiaModel->getTiposActivos(),
        ]);

        return view('rotacion/tipos_dia/index', $data);
    }
}
