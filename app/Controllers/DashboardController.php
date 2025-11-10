<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DashboardController extends ResourceController
{
     protected $session;
    protected $usuarioModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->usuarioModel = new UsuarioModel();
        
        // Verificar si el usuario está logueado
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }
    }

    public function index()
    {
        $data = [
            'titulo' => 'Dashboard Principal',
            'usuario_id' => $this->session->get('usuario_id'),
            'usuario_nombre' => $this->session->get('usuario_nombre'),
            'usuario_apellido' => $this->session->get('usuario_apellido'),
            'usuario_alias' => $this->session->get('usuario_alias'),
            'usuario_email' => $this->session->get('usuario_email'),
            'usuario_nivel' => $this->session->get('usuario_nivel'),
            'mensaje_estado' => $this->session->get('mensaje_estado'),
            'total_usuarios' => $this->usuarioModel->countAll()
        ];

        return view('dashboard/index', $data);
    }

    public function administrarUsuarios()
    {
        // Solo usuarios de nivel 'sistema' pueden acceder
        if ($this->session->get('usuario_nivel') !== 'sistema') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos para acceder a esta sección.');
        }

        $data = [
            'titulo' => 'Administrar Usuarios',
            'usuarios' => $this->usuarioModel->findAll()
        ];

        return view('dashboard/usuarios', $data);
    }

    public function cambiarEstadoUsuario($id)
    {
        if ($this->session->get('usuario_nivel') !== 'sistema') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos para esta acción.');
        }

        $usuario = $this->usuarioModel->find($id);
        
        if ($usuario) {
            $nuevoEstado = $usuario['activo'] ? 0 : 1;
            $this->usuarioModel->update($id, ['activo' => $nuevoEstado]);
            
            $estadoTexto = $nuevoEstado ? 'activada' : 'desactivada';
            return redirect()->back()->with('success', "Cuenta de {$usuario['nombre']} {$usuario['apellido']} {$estadoTexto} correctamente.");
        }

        return redirect()->back()->with('error', 'Usuario no encontrado.');
    }

    public function cambiarNivelUsuario($id)
    {
        if ($this->session->get('usuario_nivel') !== 'sistema') {
            return redirect()->to('/dashboard')->with('error', 'No tienes permisos para esta acción.');
        }

        $usuario = $this->usuarioModel->find($id);
        
        if ($usuario) {
            $nuevoNivel = $usuario['nivel'] === 'usuario' ? 'sistema' : 'usuario';
            $this->usuarioModel->update($id, ['nivel' => $nuevoNivel]);
            
            return redirect()->back()->with('success', "Nivel de {$usuario['nombre']} cambiado a {$nuevoNivel} correctamente.");
        }

        return redirect()->back()->with('error', 'Usuario no encontrado.');
    }
}
