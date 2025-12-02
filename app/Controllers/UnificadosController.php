<?php

namespace App\Controllers;

use App\Models\UnificadoModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class UnificadosController extends BaseController
{
    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new UnificadoModel();
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
        $unificados = $this->model->getUnificados();

        // Filtrar por búsqueda si existe
        if ($search) {
            $unificados = array_filter($unificados, function ($unificado) use ($search) {
                return stripos($unificado['denominacion'], $search) !== false;
            });
        }

        $data = array_merge($this->data, [
            'title' => 'Unificados - SGC',
            'unificados' => $unificados,
            'search' => $search
        ]);

        return view('unificados/index', $data);
    }

    public function show($id = null)
    {
        $unificado = $this->model->find($id);
        if (!$unificado) throw new PageNotFoundException('No se encontró la unificación.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Unificación - SGC',
            'unificado' => $unificado
        ]);

        return view('unificados/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nueva Unificación - SGC'
        ]);

        return view('unificados/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'denominacion' => $this->request->getPost('denominacion'),
        ];

        // Validar que la denominación no exista
        $existe = $this->model->where('denominacion', $data['denominacion'])->first();
        if ($existe) {
            return redirect()->back()->withInput()->with('errors', ['La denominación ya existe.']);
        }

        // Crear unificación
        if ($this->model->save($data)) {
            return redirect()->to('/unificados')->with('success', 'Unificación creada correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $unificado = $this->model->find($id);
        if (!$unificado) throw new PageNotFoundException('No se encontró la unificación.');

        $data = array_merge($this->data, [
            'title' => 'Editar Unificación - SGC',
            'unificado' => $unificado
        ]);

        return view('unificados/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'denominacion' => $this->request->getPost('denominacion'),
        ];

        // Validar que la denominación no exista (excluyendo el actual)
        $existe = $this->model->where('denominacion', $data['denominacion'])
            ->where('id !=', $id)
            ->first();
        if ($existe) {
            return redirect()->back()->withInput()->with('errors', ['La denominación ya existe.']);
        }

        // Actualizar unificación
        if ($this->model->update($id, $data)) {
            return redirect()->to('/unificados')->with('success', 'Unificación actualizada correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $unificado = $this->model->find($id);
        if (!$unificado) throw new PageNotFoundException('No se encontró la unificación.');

        // TODO: Verificar si la unificación tiene concursos asociados antes de eliminar
        // Por ahora solo eliminamos

        if ($this->model->delete($id)) {
            return redirect()->to('/unificados')->with('success', 'Unificación eliminada correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar la unificación.');
    }
}
