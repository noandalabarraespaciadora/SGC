<?php

namespace App\Controllers;

use App\Models\ModalidadModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;


class ModalidadesController extends BaseController
{
 protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new ModalidadModel();
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
        $modalidades = $search ? $this->model->search($search) : $this->model->getModalidades();

        $data = array_merge($this->data, [
            'title' => 'Modalidades - SGC',
            'modalidades' => $modalidades,
            'search' => $search
        ]);

        return view('modalidades/index', $data);
    }

    public function show($id = null)
    {
        $modalidad = $this->model->find($id);
        if (!$modalidad) throw new PageNotFoundException('No se encontró la modalidad.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Modalidad - SGC',
            'modalidad' => $modalidad
        ]);

        return view('modalidades/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nueva Modalidad - SGC'
        ]);

        return view('modalidades/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['modalidad' => $this->request->getPost('modalidad')];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/modalidades')->with('success', 'Modalidad creada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $modalidad = $this->model->find($id);
        if (!$modalidad) throw new PageNotFoundException('No se encontró la modalidad.');

        $data = array_merge($this->data, [
            'title' => 'Editar Modalidad - SGC',
            'modalidad' => $modalidad
        ]);

        return view('modalidades/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['modalidad' => $this->request->getPost('modalidad')];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/modalidades')->with('success', 'Modalidad actualizada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $modalidad = $this->model->find($id);
        if (!$modalidad) throw new PageNotFoundException('No se encontró la modalidad.');

        if ($this->model->delete($id)) {
            return redirect()->to('/modalidades')->with('success', 'Modalidad eliminada exitosamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la modalidad.');
    }
}
