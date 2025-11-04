<?php

namespace App\Controllers;

/**
 * AuthController
 *
 * Handles user authentication processes.
 *
 * @package App\Controllers
 */


use App\Models\UsuarioModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends BaseController
{
    protected $usuarioModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->session = \Config\Services::session();
        $this->validation = \Config\Services::validation();
        helper(['form', 'url', 'text']);
    }

    public function login()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'titulo' => 'Iniciar Sesión - Sistema'
        ];

        return view('auth/login', $data);
    }

    public function procesarLogin()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/login')->with('error', 'Método no permitido');
        }

        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        log_message('debug', 'Intentando login para: ' . $email);
        log_message('debug', 'Password recibido: ' . $password);

        $usuario = $this->usuarioModel->verificarUsuario($email, $password);

        if ($usuario) {
            log_message('debug', 'Usuario encontrado y verificado: ' . $email);

            $sessionData = [
                'usuario_id' => $usuario['id'],
                'usuario_nombre' => $usuario['nombre'],
                'usuario_apellido' => $usuario['apellido'],
                'usuario_alias' => $usuario['alias'],
                'usuario_email' => $usuario['email'],
                'usuario_nivel' => $usuario['nivel'],
                'logged_in' => true
            ];

            $this->session->set($sessionData);
            return redirect()->to('/dashboard')->with('success', '¡Bienvenido!');
        } else {
            log_message('debug', 'Falló la verificación para: ' . $email);
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas o cuenta inactiva');
        }
    }

    public function procesarLogin2()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->verificarUsuario($email, $password);

        if ($usuario) {
            $sessionData = [
                'usuario_id' => $usuario['id'],
                'usuario_nombre' => $usuario['nombre'],
                'usuario_apellido' => $usuario['apellido'],
                'usuario_alias' => $usuario['alias'],
                'usuario_email' => $usuario['email'],
                'usuario_nivel' => $usuario['nivel'],
                'logged_in' => true
            ];

            $this->session->set($sessionData);

            $mensajeBienvenida = "¡Bienvenido {$usuario['nombre']} {$usuario['apellido']} ({$usuario['alias']})!";
            return redirect()->to('/dashboard')->with('success', $mensajeBienvenida);
        } else {
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas o cuenta inactiva');
        }
    }

    public function register()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'titulo' => 'Registrarse - Sistema'
        ];

        return view('auth/register', $data);
    }

    public function procesarRegistro()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'apellido' => 'required|min_length[2]|max_length[100]',
            'alias' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.alias]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'telefono' => 'permit_empty|min_length[8]|max_length[20]',
            'direccion' => 'permit_empty|max_length[500]',
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // Generar alias único si está vacío
        $alias = $this->request->getPost('alias');
        if (empty($alias)) {
            $nombre = $this->request->getPost('nombre');
            $apellido = $this->request->getPost('apellido');
            $baseAlias = strtolower($nombre . '.' . $apellido);
            $alias = $this->generarAliasUnico($baseAlias);
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'alias' => $alias,
            'email' => $this->request->getPost('email'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'password' => $this->request->getPost('password'),
            'nivel' => 'usuario' // Por defecto
        ];

        if ($this->usuarioModel->save($data)) {
            return redirect()->to('/login')->with('success', '¡Registro exitoso! Ahora puedes iniciar sesión.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al registrar el usuario. Inténtalo de nuevo.');
        }
    }

    private function generarAliasUnico($baseAlias)
    {
        $alias = $baseAlias;
        $contador = 1;

        while ($this->usuarioModel->buscarPorAlias($alias)) {
            $alias = $baseAlias . $contador;
            $contador++;
        }

        return $alias;
    }

    public function logout()
    {
        $nombreUsuario = $this->session->get('usuario_nombre');
        $this->session->destroy();

        return redirect()->to('/login')->with('success', "¡Hasta pronto {$nombreUsuario}! Sesión cerrada correctamente.");
    }

    public function perfil()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');
        $usuario = $this->usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->to('/dashboard')->with('error', 'Usuario no encontrado.');
        }

        $data = [
            'titulo' => 'Mi Perfil',
            'usuario' => $usuario
        ];

        return view('auth/perfil', $data);
    }

    public function actualizarPerfil()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');
        $usuario = $this->usuarioModel->find($usuarioId);

        if (!$usuario) {
            return redirect()->to('/dashboard')->with('error', 'Usuario no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'apellido' => 'required|min_length[2]|max_length[100]',
            'alias' => "required|min_length[3]|max_length[50]|is_unique[usuarios.alias,id,{$usuarioId}]",
            'telefono' => 'permit_empty|min_length[8]|max_length[20]',
            'direccion' => 'permit_empty|max_length[500]'
        ];

        // Validar datos básicos
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $data = [
            'id' => $usuarioId,
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'alias' => $this->request->getPost('alias'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion')
        ];

        // Guardar datos básicos
        if ($this->usuarioModel->save($data)) {
            // Actualizar datos de sesión
            $this->session->set([
                'usuario_nombre' => $data['nombre'],
                'usuario_apellido' => $data['apellido'],
                'usuario_alias' => $data['alias']
            ]);

            return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil.');
        }
    }

    public function cambiarPassword()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');

        $rules = [
            'password_actual' => 'required',
            'nueva_password' => 'required|min_length[8]',
            'confirmar_password' => 'required|matches[nueva_password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/perfil')->with('errors_password', $this->validation->getErrors());
        }

        $passwordActual = $this->request->getPost('password_actual');
        $nuevaPassword = $this->request->getPost('nueva_password');

        // Verificar contraseña actual
        if (!$this->usuarioModel->verificarPassword($usuarioId, $passwordActual)) {
            return redirect()->to('/perfil')->with('error_password', 'La contraseña actual es incorrecta.');
        }

        // Método directo a la base de datos para evitar validaciones del modelo
        $db = \Config\Database::connect();
        $hashedPassword = password_hash($nuevaPassword, PASSWORD_DEFAULT);

        $builder = $db->table('usuarios');
        $builder->where('id', $usuarioId);
        $result = $builder->update(['password' => $hashedPassword]);

        if ($result) {
            return redirect()->to('/perfil')->with('success_password', 'Contraseña cambiada correctamente.');
        } else {
            return redirect()->to('/perfil')->with('error_password', 'Error al cambiar la contraseña en la base de datos.');
        }
    }
}
