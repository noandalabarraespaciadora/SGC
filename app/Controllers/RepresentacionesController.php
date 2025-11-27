<?php

namespace App\Controllers;

use App\Models\RepresentacionModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;


class RepresentacionesController extends BaseController
{
 protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new RepresentacionModel();
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
        $representaciones = $search ? $this->model->search($search) : $this->model->getRepresentaciones();

        $data = array_merge($this->data, [
            'title' => 'Representaciones - SGC',
            'representaciones' => $representaciones,
            'search' => $search
        ]);

        return view('representaciones/index', $data);
    }

    public function show($id = null)
    {
        $representacion = $this->model->find($id);
        if (!$representacion) throw new PageNotFoundException('No se encontró la representación.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Representación - SGC',
            'representacion' => $representacion
        ]);

        return view('representaciones/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nueva Representación - SGC'
        ]);

        return view('representaciones/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['representacion' => $this->request->getPost('representacion')];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/representaciones')->with('success', 'Representación creada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $representacion = $this->model->find($id);
        if (!$representacion) throw new PageNotFoundException('No se encontró la representación.');

        $data = array_merge($this->data, [
            'title' => 'Editar Representación - SGC',
            'representacion' => $representacion
        ]);

        return view('representaciones/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = ['representacion' => $this->request->getPost('representacion')];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/representaciones')->with('success', 'Representación actualizada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $representacion = $this->model->find($id);
        if (!$representacion) throw new PageNotFoundException('No se encontró la representación.');

        if ($this->model->delete($id)) {
            return redirect()->to('/representaciones')->with('success', 'Representación eliminada exitosamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la representación.');
    }
}
