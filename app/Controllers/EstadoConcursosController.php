<?php

namespace App\Controllers;

use App\Models\EstadoConcursoModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class EstadoConcursosController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new EstadoConcursoModel();
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
        $estadoConcursos = $search ? $this->model->search($search) : $this->model->getEstadoConcursos();

        $data = array_merge($this->data, [
            'title' => 'Estados de Concurso - SGC',
            'estadoConcursos' => $estadoConcursos,
            'search' => $search
        ]);

        return view('estado_concursos/index', $data);
    }

    public function show($id = null)
    {
        $estadoConcurso = $this->model->find($id);
        if (!$estadoConcurso) throw new PageNotFoundException('No se encontró el estado de concurso.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Estado de Concurso - SGC',
            'estadoConcurso' => $estadoConcurso
        ]);

        return view('estado_concursos/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Estado de Concurso - SGC'
        ]);

        return view('estado_concursos/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['denominacion' => $this->request->getPost('denominacion')];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/estado-concursos')->with('success', 'Estado de concurso creado exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $estadoConcurso = $this->model->find($id);
        if (!$estadoConcurso) throw new PageNotFoundException('No se encontró el estado de concurso.');

        $data = array_merge($this->data, [
            'title' => 'Editar Estado de Concurso - SGC',
            'estadoConcurso' => $estadoConcurso
        ]);

        return view('estado_concursos/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['denominacion' => $this->request->getPost('denominacion')];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/estado-concursos')->with('success', 'Estado de concurso actualizado exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $estadoConcurso = $this->model->find($id);
        if (!$estadoConcurso) throw new PageNotFoundException('No se encontró el estado de concurso.');

        if ($this->model->delete($id)) {
            return redirect()->to('/estado-concursos')->with('success', 'Estado de concurso eliminado exitosamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el estado de concurso.');
    }
}
