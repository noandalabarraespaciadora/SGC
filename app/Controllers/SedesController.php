<?php

namespace App\Controllers;

use App\Models\SedeModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class SedesController extends BaseController
{
 protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new SedeModel();
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
        $sedes = $search ? $this->model->search($search) : $this->model->getSedes();

        $data = array_merge($this->data, [
            'title' => 'Sedes - SGC',
            'sedes' => $sedes,
            'search' => $search
        ]);

        return view('sedes/index', $data);
    }

    public function show($id = null)
    {
        $sede = $this->model->find($id);
        if (!$sede) throw new PageNotFoundException('No se encontró la sede.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Sede - SGC',
            'sede' => $sede
        ]);

        return view('sedes/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nueva Sede - SGC'
        ]);

        return view('sedes/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'denominacion' => $this->request->getPost('denominacion'),
            'direccion' => $this->request->getPost('direccion'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono')
        ];

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/sedes')->with('success', 'Sede creada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $sede = $this->model->find($id);
        if (!$sede) throw new PageNotFoundException('No se encontró la sede.');

        $data = array_merge($this->data, [
            'title' => 'Editar Sede - SGC',
            'sede' => $sede
        ]);

        return view('sedes/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'denominacion' => $this->request->getPost('denominacion'),
            'direccion' => $this->request->getPost('direccion'),
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono')
        ];

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/sedes')->with('success', 'Sede actualizada exitosamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $sede = $this->model->find($id);
        if (!$sede) throw new PageNotFoundException('No se encontró la sede.');

        if ($this->model->delete($id)) {
            return redirect()->to('/sedes')->with('success', 'Sede eliminada exitosamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la sede.');
    }
}
