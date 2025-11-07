<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $usuarioModel;
    protected $session;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = \Config\Services::session();
        helper(['form', 'url']);
    }

    public function index()
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        $usuarios = $this->usuarioModel->findAll();

        $data = [
            'titulo' => 'Administración de Usuarios',
            'usuarios' => $usuarios
        ];

        return view('admin/usuarios', $data);
    }

    public function cambiarAprobacion($id)
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado');
        }

        $nuevoEstado = $usuario['aprobado'] ? 0 : 1;
        
        $this->usuarioModel->update($id, ['aprobado' => $nuevoEstado]);

        $mensaje = $nuevoEstado ? 'Usuario aprobado correctamente' : 'Usuario desaprobado correctamente';
        return redirect()->to('/admin/usuarios')->with('success', $mensaje);
    }

    public function resetearPassword($id)
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        $usuario = $this->usuarioModel->find($id);
        
        if (!$usuario) {
            return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado');
        }

        // Generar contraseña temporal
        $nuevaPassword = bin2hex(random_bytes(4)); // 8 caracteres
        $this->usuarioModel->update($id, ['password' => $nuevaPassword]);

        return redirect()->to('/admin/usuarios')->with('success', 
            "Contraseña reseteada. Nueva contraseña temporal: <strong>$nuevaPassword</strong>");
    }

    public function editarUsuario($id = null)
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        if ($id) {
            $usuario = $this->usuarioModel->find($id);
            if (!$usuario) {
                return redirect()->to('/admin/usuarios')->with('error', 'Usuario no encontrado');
            }
        } else {
            $usuario = null;
        }

        $data = [
            'titulo' => $id ? 'Editar Usuario' : 'Crear Usuario',
            'usuario' => $usuario
        ];

        return view('admin/editar_usuario', $data);
    }

    public function guardarUsuario($id = null)
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        $rules = [
            'apellido' => 'required|min_length[2]|max_length[100]',
            'nombre' => 'required|min_length[2]|max_length[100]',
            'alias' => 'required|min_length[3]|max_length[50]',
            'email' => 'required|valid_email',
            'dni' => 'permit_empty|min_length[7]|max_length[10]',
            'rol' => 'required|in_list[Usuario,Experto,Sistemas]',
            'estado' => 'required|in_list[Activo,Ausente,No Disponible,Ocupado]'
        ];

        if (!$id) {
            $rules['alias'] .= '|is_unique[usuarios.alias]';
            $rules['email'] .= '|is_unique[usuarios.email]';
            $rules['password'] = 'required|min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $this->request->getPost('alias'),
            'email' => $this->request->getPost('email'),
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'cargo_actual' => $this->request->getPost('cargo_actual'),
            'dependencia' => $this->request->getPost('dependencia'),
            'mensaje_estado' => $this->request->getPost('mensaje_estado'),
            'rol' => $this->request->getPost('rol'),
            'estado' => $this->request->getPost('estado'),
            'aprobado' => $this->request->getPost('aprobado') ? 1 : 0
        ];

        if (!$id || $this->request->getPost('password')) {
            $data['password'] = $this->request->getPost('password');
        }

        if ($id) {
            $this->usuarioModel->update($id, $data);
            $mensaje = 'Usuario actualizado correctamente';
        } else {
            $this->usuarioModel->insert($data);
            $mensaje = 'Usuario creado correctamente';
        }

        return redirect()->to('/admin/usuarios')->with('success', $mensaje);
    }

    public function cambiarEstado($id, $estado)
    {
        if (!$this->session->get('logged_in') || $this->session->get('usuario_rol') !== 'Sistemas') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos de administrador');
        }

        $estadosPermitidos = ['Activo', 'Ausente', 'No Disponible', 'Ocupado'];
        
        if (!in_array($estado, $estadosPermitidos)) {
            return redirect()->to('/admin/usuarios')->with('error', 'Estado no válido');
        }

        $this->usuarioModel->update($id, ['estado' => $estado]);

        return redirect()->to('/admin/usuarios')->with('success', "Estado cambiado a: $estado");
    }
}