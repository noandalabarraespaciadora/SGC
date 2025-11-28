<?php

namespace App\Controllers;

use App\Models\ActividadModel;
use App\Models\SedeModel;
use App\Models\ModalidadModel;
use App\Models\TipoActividadModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class ActividadesController extends BaseController
{
    protected $model;
    protected $sedeModel;
    protected $modalidadModel;
    protected $tipoActividadModel;
    protected $data = [];

    public function __construct()
    {
        $this->model = new ActividadModel();
        $this->sedeModel = new SedeModel();
        $this->modalidadModel = new ModalidadModel();
        $this->tipoActividadModel = new TipoActividadModel();

        // Cargar datos del usuario desde la sesión
        $this->data['usuario_nombre'] = session()->get('usuario_nombre');
        $this->data['usuario_apellido'] = session()->get('usuario_apellido');
        $this->data['usuario_alias'] = session()->get('usuario_alias');
        $this->data['usuario_rol'] = session()->get('usuario_rol');
        $this->data['usuario_mensaje_estado'] = session()->get('usuario_mensaje_estado');
    }

    /**
     * Lista de actividades
     */
    public function index()
    {
        $search = $this->request->getGet('search');

        if ($search) {
            $actividades = $this->model->search($search);
        } else {
            $actividades = $this->model->getActividades();
        }

        $data = array_merge($this->data, [
            'title' => 'Actividades - SGC',
            'actividades' => $actividades,
            'search' => $search
        ]);

        return view('actividades/index', $data);
    }

    /**
     * Vista de calendario
     */
    public function calendario()
    {
        $view = $this->request->getGet('view') ?? 'month';
        $date = $this->request->getGet('date') ?? date('Y-m-d');

        // Obtener actividades para un rango amplio (1 año antes y 1 año después)
        // Esto permite navegar por el calendario sin recargar
        $startDate = date('Y-m-01', strtotime('-1 year', strtotime($date)));
        $endDate = date('Y-m-t', strtotime('+1 year', strtotime($date)));

        $actividades = $this->model->getActividadesCalendario($startDate, $endDate);

        $data = array_merge($this->data, [
            'title' => 'Calendario de Actividades - SGC',
            'actividades' => $actividades,
            'currentView' => $view,
            'currentDate' => $date,
            'sedes' => $this->sedeModel->findAll(),
            'modalidades' => $this->modalidadModel->findAll(),
            'tiposActividad' => $this->tipoActividadModel->findAll()
        ]);

        return view('actividades/calendario', $data);
    }

    /**
     * Vista de lista (alternativa)
     */
    public function lista()
    {
        $search = $this->request->getGet('search');
        $filtroTipo = $this->request->getGet('tipo');
        $filtroSede = $this->request->getGet('sede');
        $filtroModalidad = $this->request->getGet('modalidad');
        $fechaDesde = $this->request->getGet('fecha_desde');
        $fechaHasta = $this->request->getGet('fecha_hasta');

        $actividades = $this->model->getActividades();

        // Aplicar filtros
        if ($search || $filtroTipo || $filtroSede || $filtroModalidad || $fechaDesde || $fechaHasta) {
            $actividades = array_filter($actividades, function ($actividad) use ($filtroTipo, $filtroSede, $filtroModalidad, $fechaDesde, $fechaHasta) {
                $cumpleTipo = !$filtroTipo || $actividad['id_tipo_actividad'] == $filtroTipo;
                $cumpleSede = !$filtroSede || $actividad['id_sede'] == $filtroSede;
                $cumpleModalidad = !$filtroModalidad || $actividad['id_modalidad'] == $filtroModalidad;
                $cumpleFechaDesde = !$fechaDesde || ($actividad['fecha'] && $actividad['fecha'] >= $fechaDesde);
                $cumpleFechaHasta = !$fechaHasta || ($actividad['fecha'] && $actividad['fecha'] <= $fechaHasta);

                return $cumpleTipo && $cumpleSede && $cumpleModalidad && $cumpleFechaDesde && $cumpleFechaHasta;
            });
        }

        $data = array_merge($this->data, [
            'title' => 'Lista de Actividades - SGC',
            'actividades' => $actividades,
            'search' => $search,
            'filtros' => [
                'tipo' => $filtroTipo,
                'sede' => $filtroSede,
                'modalidad' => $filtroModalidad,
                'fecha_desde' => $fechaDesde,
                'fecha_hasta' => $fechaHasta
            ],
            'sedes' => $this->sedeModel->findAll(),
            'modalidades' => $this->modalidadModel->findAll(),
            'tiposActividad' => $this->tipoActividadModel->findAll()
        ]);

        return view('actividades/lista', $data);
    }

    /**
     * Ver detalle de una actividad
     */
    public function show($id = null)
    {
        $actividad = $this->model->find($id);

        if (!$actividad) {
            throw new PageNotFoundException('No se encontró la actividad solicitada.');
        }

        // Cargar datos relacionados
        $actividad['sede'] = $this->sedeModel->find($actividad['id_sede']);
        $actividad['modalidad'] = $this->modalidadModel->find($actividad['id_modalidad']);
        $actividad['tipo_actividad'] = $this->tipoActividadModel->find($actividad['id_tipo_actividad']);

        $data = array_merge($this->data, [
            'title' => 'Detalle de Actividad - SGC',
            'actividad' => $actividad
        ]);

        return view('actividades/show', $data);
    }

    /**
     * Mostrar formulario de creación
     */
    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nueva Actividad - SGC',
            'sedes' => $this->sedeModel->findAll(),
            'modalidades' => $this->modalidadModel->findAll(),
            'tiposActividad' => $this->tipoActividadModel->findAll()
        ]);

        return view('actividades/new', $data);
    }

    /**
     * Crear nueva actividad
     */
    public function create()
    {
        // Validar CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'fecha' => $this->request->getPost('fecha'),
            'hora' => $this->request->getPost('hora'),
            'duracion' => $this->request->getPost('duracion'),
            'id_sede' => $this->request->getPost('id_sede'),
            'id_modalidad' => $this->request->getPost('id_modalidad'),
            'id_tipo_actividad' => $this->request->getPost('id_tipo_actividad'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        // Convertir vacíos a null
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        // Validar para creación
        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/actividades')->with('success', 'Actividad creada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id = null)
    {
        $actividad = $this->model->find($id);

        if (!$actividad) {
            throw new PageNotFoundException('No se encontró la actividad solicitada.');
        }

        $data = array_merge($this->data, [
            'title' => 'Editar Actividad - SGC',
            'actividad' => $actividad,
            'sedes' => $this->sedeModel->findAll(),
            'modalidades' => $this->modalidadModel->findAll(),
            'tiposActividad' => $this->tipoActividadModel->findAll()
        ]);

        return view('actividades/edit', $data);
    }

    public function update($id = null)
    {
        // Validar que el ID existe
        if (!$id) {
            return redirect()->back()->with('error', 'ID de actividad no válido.');
        }

        // Verificar que la actividad existe
        $actividadExistente = $this->model->find($id);
        if (!$actividadExistente) {
            throw new PageNotFoundException('No se encontró la actividad solicitada.');
        }

        // Validar CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'fecha' => $this->request->getPost('fecha'),
            'hora' => $this->request->getPost('hora'),
            'duracion' => $this->request->getPost('duracion'),
            'id_sede' => $this->request->getPost('id_sede'),
            'id_modalidad' => $this->request->getPost('id_modalidad'),
            'id_tipo_actividad' => $this->request->getPost('id_tipo_actividad'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        // Convertir vacíos a null
        foreach ($data as $key => $value) {
            if ($value === '') {
                $data[$key] = null;
            }
        }

        // Validar para edición (pasa el ID como segundo parámetro)
        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/actividades')->with('success', 'Actividad actualizada exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    /**
     * Eliminar actividad (soft delete)
     */
    public function delete($id = null)
    {
        $actividad = $this->model->find($id);

        if (!$actividad) {
            throw new PageNotFoundException('No se encontró la actividad solicitada.');
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/actividades')->with('success', 'Actividad eliminada exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo eliminar la actividad.');
        }
    }

    /**
     * API para obtener actividades en formato JSON (para calendario)
     */
    public function apiActividades()
    {
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $actividades = $this->model->getActividadesCalendario($start, $end);

        $events = [];
        foreach ($actividades as $actividad) {
            $events[] = [
                'id' => $actividad['id'],
                'title' => $actividad['titulo'],
                'start' => $actividad['fecha'] . ($actividad['hora'] ? 'T' . $actividad['hora'] : ''),
                'end' => $this->calcularFinEvento($actividad),
                'color' => $actividad['tipo_color'] ?? '#007bff',
                'extendedProps' => [
                    'sede' => $actividad['sede_nombre'],
                    'modalidad' => $actividad['modalidad_nombre'],
                    'tipo' => $actividad['tipo_actividad_nombre'],
                    'duracion' => $actividad['duracion'],
                    'descripcion' => $actividad['descripcion']
                ]
            ];
        }

        return $this->response->setJSON($events);
    }

    /**
     * Calcular fecha/hora de fin del evento
     */
    private function calcularFinEvento($actividad)
    {
        if (!$actividad['fecha']) {
            return null;
        }

        if ($actividad['hora'] && $actividad['duracion']) {
            $startDateTime = \DateTime::createFromFormat('Y-m-d H:i:s', $actividad['fecha'] . ' ' . $actividad['hora']);
            $startDateTime->modify("+{$actividad['duracion']} minutes");
            return $startDateTime->format('Y-m-d\TH:i:s');
        }

        return $actividad['fecha'];
    }
}
