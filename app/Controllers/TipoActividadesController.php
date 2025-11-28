<?php

namespace App\Controllers;

use App\Models\TipoActividadModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class TipoActividadesController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new TipoActividadModel();
        $this->data = [
            'usuario_nombre' => session()->get('usuario_nombre'),
            'usuario_apellido' => session()->get('usuario_apellido'),
            'usuario_alias' => session()->get('usuario_alias'),
            'usuario_rol' => session()->get('usuario_rol'),
            'usuario_mensaje_estado' => session()->get('usuario_mensaje_estado')
        ];
    }

    public function index()
    {
        $search = $this->request->getGet('search');
        $tipoActividades = $search ? $this->model->search($search) : $this->model->getTipoActividades();

        $data = array_merge($this->data, [
            'title' => 'Tipos de Actividades - SGC',
            'tipoActividades' => $tipoActividades,
            'search' => $search
        ]);

        return view('tipo_actividades/index', $data);
    }

    public function show($id = null)
    {
        $tipoActividad = $this->model->find($id);
        if (!$tipoActividad) throw new PageNotFoundException('No se encontró el tipo de actividad.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Tipo de Actividad - SGC',
            'tipoActividad' => $tipoActividad,
            'color' => $tipoActividad['color']
        ]);

        return view('tipo_actividades/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Tipo de Actividad - SGC'
        ]);

        return view('tipo_actividades/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'actividad' => $this->request->getPost('actividad'),
            'color' => $this->request->getPost('color')
        ];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/tipo-actividades')->with('success', 'Tipo de actividad creado exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $tipoActividad = $this->model->find($id);
        if (!$tipoActividad) throw new PageNotFoundException('No se encontró el tipo de actividad.');

        $data = array_merge($this->data, [
            'title' => 'Editar Tipo de Actividad - SGC',
            'tipoActividad' => $tipoActividad
        ]);

        return view('tipo_actividades/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'actividad' => $this->request->getPost('actividad'),
            'color' => $this->request->getPost('color')
        ];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/tipo-actividades')->with('success', 'Tipo de actividad actualizado exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $tipoActividad = $this->model->find($id);
        if (!$tipoActividad) throw new PageNotFoundException('No se encontró el tipo de actividad.');

        if ($this->model->delete($id)) {
            return redirect()->to('/tipo-actividades')->with('success', 'Tipo de actividad eliminado exitosamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el tipo de actividad.');
    }
}
