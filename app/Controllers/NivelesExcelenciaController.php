<?php

namespace App\Controllers;

use App\Models\NivelExcelenciaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class NivelesExcelenciaController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new NivelExcelenciaModel();
        // Cargar datos del usuario desde la sesión
        $this->data['usuario_nombre'] = session()->get('usuario_nombre');
        $this->data['usuario_apellido'] = session()->get('usuario_apellido');
        $this->data['usuario_alias'] = session()->get('usuario_alias');
        $this->data['usuario_rol'] = session()->get('usuario_rol');
        $this->data['usuario_mensaje_estado'] = session()->get('usuario_mensaje_estado');
    }

    /**
     * Lista de niveles de excelencia
     */
    public function index()
    {
        $search = $this->request->getGet('search');
        
        if ($search) {
            $niveles = $this->model->search($search);
        } else {
            $niveles = $this->model->getNiveles();
        }

        $data = array_merge($this->data, [
            'title' => 'Niveles de Excelencia - SGC',
            'niveles' => $niveles,
            'search' => $search
        ]);

        return view('niveles_excelencia/index', $data);
    }

    /**
     * Ver detalle de un nivel
     */
    public function show($id = null)
    {
        $nivel = $this->model->find($id);

        if (!$nivel) {
            throw new PageNotFoundException('No se encontró el nivel de excelencia solicitado.');
        }

        $data = array_merge($this->data, [
            'title' => 'Detalle del Nivel - SGC',
            'nivel' => $nivel
        ]);

        return view('niveles_excelencia/show', $data);
    }

    /**
     * Mostrar formulario de creación
     */
    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Nivel de Excelencia - SGC'
        ]);

        return view('niveles_excelencia/new', $data);
    }

    /**
     * Crear nuevo nivel
     */
    public function create()
    {
        // Validar CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'nivel' => $this->request->getPost('nivel'),
            'abreviatura' => $this->request->getPost('abreviatura')
        ];

        // Validar para creación
        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/niveles-excelencia')->with('success', 'Nivel de excelencia creado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit($id = null)
    {
        $nivel = $this->model->find($id);

        if (!$nivel) {
            throw new PageNotFoundException('No se encontró el nivel de excelencia solicitado.');
        }

        $data = array_merge($this->data, [
            'title' => 'Editar Nivel de Excelencia - SGC',
            'nivel' => $nivel
        ]);

        return view('niveles_excelencia/edit', $data);
    }

    /**
     * Actualizar nivel
     */
    public function update($id = null)
    {
        // Validar CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'nivel' => $this->request->getPost('nivel'),
            'abreviatura' => $this->request->getPost('abreviatura')
        ];

        // Validar para edición
        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/niveles-excelencia')->with('success', 'Nivel de excelencia actualizado exitosamente.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }
    }

    /**
     * Eliminar nivel (soft delete)
     */
    public function delete($id = null)
    {
        $nivel = $this->model->find($id);

        if (!$nivel) {
            throw new PageNotFoundException('No se encontró el nivel de excelencia solicitado.');
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/niveles-excelencia')->with('success', 'Nivel de excelencia eliminado exitosamente.');
        } else {
            return redirect()->back()->with('error', 'No se pudo eliminar el nivel de excelencia.');
        }
    }
}