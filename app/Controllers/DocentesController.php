<?php

namespace App\Controllers;


use App\Models\DocenteModel;
use App\Models\DocenteEmailModel;
use App\Models\DocenteTelefonoModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;


class DocentesController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new DocenteModel();
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
        $docentes = $search ? $this->model->search($search) : $this->model->getDocentes();

        // Obtener contactos para cada docente
        foreach ($docentes as &$docente) {
            $docente['emails'] = $this->model->getEmails($docente['id']);
            $docente['telefonos'] = $this->model->getTelefonos($docente['id']);
        }

        $data = array_merge($this->data, [
            'title' => 'Docentes - SGC',
            'docentes' => $docentes,
            'search' => $search
        ]);

        return view('docentes/index', $data);
    }

    public function show($id = null)
    {
        $docente = $this->model->find($id);
        if (!$docente) throw new PageNotFoundException('No se encontró el docente.');

        // Obtener contactos
        $docente['emails'] = $this->model->getEmails($id);
        $docente['telefonos'] = $this->model->getTelefonos($id);

        $data = array_merge($this->data, [
            'title' => 'Detalle de Docente - SGC',
            'docente' => $docente
        ]);

        return view('docentes/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Docente - SGC'
        ]);

        return view('docentes/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'apellido_y_nombre' => $this->request->getPost('apellido_y_nombre'),
            'direccion' => $this->request->getPost('direccion'),
        ];

        // Procesar imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/docentes', $nuevoNombre);
            $data['url_foto'] = 'uploads/docentes/' . $nuevoNombre;
        }

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Guardar docente
        if ($this->model->save($data)) {
            $docenteId = $this->model->getInsertID();

            // Guardar contactos
            $emails = $this->request->getPost('emails');
            $telefonos = $this->request->getPost('telefonos');

            $this->model->guardarEmails($docenteId, $emails);
            $this->model->guardarTelefonos($docenteId, $telefonos);

            return redirect()->to('/docentes')->with('success', 'Docente agregado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $docente = $this->model->find($id);
        if (!$docente) throw new PageNotFoundException('No se encontró el docente.');

        // Obtener contactos
        $docente['emails'] = $this->model->getEmails($id);
        $docente['telefonos'] = $this->model->getTelefonos($id);

        $data = array_merge($this->data, [
            'title' => 'Editar Docente - SGC',
            'docente' => $docente
        ]);

        return view('docentes/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'apellido_y_nombre' => $this->request->getPost('apellido_y_nombre'),
            'direccion' => $this->request->getPost('direccion'),
        ];

        // Procesar nueva imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            // Eliminar imagen anterior si existe
            $docente = $this->model->find($id);
            if ($docente['url_foto'] && file_exists(ROOTPATH . 'public/' . $docente['url_foto'])) {
                unlink(ROOTPATH . 'public/' . $docente['url_foto']);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/docentes', $nuevoNombre);
            $data['url_foto'] = 'uploads/docentes/' . $nuevoNombre;
        }

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        // Actualizar docente
        if ($this->model->update($id, $data)) {
            // Actualizar contactos
            $emails = $this->request->getPost('emails');
            $telefonos = $this->request->getPost('telefonos');

            $this->model->actualizarEmails($id, $emails);
            $this->model->actualizarTelefonos($id, $telefonos);

            return redirect()->to('/docentes')->with('success', 'Docente actualizado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $docente = $this->model->find($id);
        if (!$docente) throw new PageNotFoundException('No se encontró el docente.');

        // Eliminar imagen si existe
        if ($docente['url_foto'] && file_exists(ROOTPATH . 'public/' . $docente['url_foto'])) {
            unlink(ROOTPATH . 'public/' . $docente['url_foto']);
        }

        // Eliminar contactos
        $this->model->eliminarEmails($id);
        $this->model->eliminarTelefonos($id);

        // Eliminar docente
        if ($this->model->delete($id)) {
            return redirect()->to('/docentes')->with('success', 'Docente eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el docente.');
    }
}
