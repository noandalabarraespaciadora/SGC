<?php

namespace App\Controllers;

use App\Models\BibliotecaModel;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class BibliotecaController extends BaseController
{

    protected $model;
    protected $data = [];

    public function __construct()
    {
        $this->model = new BibliotecaModel();
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
        $libros = $search ? $this->model->search($search) : $this->model->getLibros();

        $data = array_merge($this->data, [
            'title' => 'Biblioteca - SGC',
            'libros' => $libros,
            'search' => $search
        ]);

        return view('biblioteca/index', $data);
    }

    public function show($id = null)
    {
        $libro = $this->model->find($id);
        if (!$libro) throw new PageNotFoundException('No se encontró el libro.');

        $data = array_merge($this->data, [
            'title' => 'Detalle de Libro - SGC',
            'libro' => $libro
        ]);

        return view('biblioteca/show', $data);
    }

    public function new()
    {
        $data = array_merge($this->data, [
            'title' => 'Nuevo Libro - SGC'
        ]);

        return view('biblioteca/new', $data);
    }

    public function create()
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'autor' => $this->request->getPost('autor'),
            'editorial' => $this->request->getPost('editorial'),
            'n_isbn' => $this->request->getPost('n_isbn'),
            'n_inventario' => $this->request->getPost('n_inventario'),
            'ubicacion' => $this->request->getPost('ubicacion'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        // Procesar imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/biblioteca', $nuevoNombre);
            $data['url_foto'] = 'uploads/biblioteca/' . $nuevoNombre;
        }

        if (!$this->model->validarCreacion($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->save($data)) {
            return redirect()->to('/biblioteca')->with('success', 'Libro agregado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function edit($id = null)
    {
        $libro = $this->model->find($id);
        if (!$libro) throw new PageNotFoundException('No se encontró el libro.');

        $data = array_merge($this->data, [
            'title' => 'Editar Libro - SGC',
            'libro' => $libro
        ]);

        return view('biblioteca/edit', $data);
    }

    public function update($id = null)
    {
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Token de seguridad inválido.');
        }

        $data = [
            'titulo' => $this->request->getPost('titulo'),
            'autor' => $this->request->getPost('autor'),
            'editorial' => $this->request->getPost('editorial'),
            'n_isbn' => $this->request->getPost('n_isbn'),
            'n_inventario' => $this->request->getPost('n_inventario'),
            'ubicacion' => $this->request->getPost('ubicacion'),
            'descripcion' => $this->request->getPost('descripcion')
        ];

        // Procesar nueva imagen si se subió
        $imagen = $this->request->getFile('url_foto');
        if ($imagen && $imagen->isValid() && !$imagen->hasMoved()) {
            // Eliminar imagen anterior si existe
            $libro = $this->model->find($id);
            if ($libro['url_foto'] && file_exists(ROOTPATH . 'public/' . $libro['url_foto'])) {
                unlink(ROOTPATH . 'public/' . $libro['url_foto']);
            }

            $nuevoNombre = $imagen->getRandomName();
            $imagen->move(ROOTPATH . 'public/uploads/biblioteca', $nuevoNombre);
            $data['url_foto'] = 'uploads/biblioteca/' . $nuevoNombre;
        }

        if (!$this->model->validarEdicion($data, $id)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        if ($this->model->update($id, $data)) {
            return redirect()->to('/biblioteca')->with('success', 'Libro actualizado correctamente.');
        }

        return redirect()->back()->withInput()->with('errors', $this->model->errors());
    }

    public function delete($id = null)
    {
        $libro = $this->model->find($id);
        if (!$libro) throw new PageNotFoundException('No se encontró el libro.');

        // Eliminar imagen si existe
        if ($libro['url_foto'] && file_exists(ROOTPATH . 'public/' . $libro['url_foto'])) {
            unlink(ROOTPATH . 'public/' . $libro['url_foto']);
        }

        if ($this->model->delete($id)) {
            return redirect()->to('/biblioteca')->with('success', 'Libro eliminado correctamente.');
        }

        return redirect()->back()->with('error', 'No se pudo eliminar el libro.');
    }
}
