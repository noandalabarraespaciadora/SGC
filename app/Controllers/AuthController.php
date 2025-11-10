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
            'titulo' => 'Iniciar Sesión - SGC'
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

        $usuario = $this->usuarioModel->verificarUsuario($email, $password);

        if ($usuario === 'cuenta_no_aprobada') {
            log_message('debug', 'Cuenta no aprobada para: ' . $email);
            return redirect()->back()->withInput()->with('error', 'Tu cuenta no ha sido aprobada. Contacta al administrador.');
        }

        if ($usuario) {
            log_message('debug', 'Usuario encontrado y verificado: ' . $email);

            $sessionData = [
                'usuario_id' => $usuario['id'],
                'usuario_nombre' => $usuario['nombre'],
                'usuario_apellido' => $usuario['apellido'],
                'usuario_alias' => $usuario['alias'],
                'usuario_email' => $usuario['email'],
                'usuario_rol' => $usuario['rol'],
                'usuario_estado' => $usuario['estado'],
                'usuario_mensaje_estado' => $usuario['mensaje_estado'] ?? '', // Agregar mensaje de estado
                'logged_in' => true
            ];

            $this->session->set($sessionData);
            return redirect()->to('/dashboard')->with('success', '¡Bienvenido!');
        } else {
            log_message('debug', 'Falló la verificación para: ' . $email);
            return redirect()->back()->withInput()->with('error', 'Credenciales incorrectas');
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
            'apellido' => 'required|min_length[2]|max_length[100]',
            'nombre' => 'required|min_length[2]|max_length[100]',
            'alias' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.alias]',
            'email' => 'required|valid_email|is_unique[usuarios.email]',
            'dni' => 'permit_empty|min_length[7]|max_length[10]',
            'fecha_nacimiento' => 'permit_empty|valid_date',
            'telefono' => 'permit_empty|min_length[8]|max_length[20]',
            'direccion' => 'permit_empty|max_length[200]',
            'cargo_actual' => 'permit_empty|max_length[200]',
            'dependencia' => 'permit_empty|max_length[200]',
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
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $alias,
            'email' => $this->request->getPost('email'),
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'cargo_actual' => $this->request->getPost('cargo_actual'),
            'dependencia' => $this->request->getPost('dependencia'),
            'password' => $this->request->getPost('password'),
            'rol' => 'Usuario', // Por defecto
            'aprobado' => 1, // Por defecto aprobado
            'estado' => 'Activo' // Por defecto activo
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
            'usuario' => $usuario,
            'usuario_id' => $this->session->get('usuario_id'),
            'usuario_nombre' => $this->session->get('usuario_nombre'),
            'usuario_apellido' => $this->session->get('usuario_apellido'),
            'usuario_alias' => $this->session->get('usuario_alias'),
            'usuario_email' => $this->session->get('usuario_email'),
            'usuario_rol' => $this->session->get('usuario_rol'),
            'usuario_estado' => $this->session->get('usuario_estado'),
            'usuario_mensaje_estado' => $this->session->get('usuario_mensaje_estado')
        ];

        return view('auth/perfil', $data);
    }

    public function actualizarPerfil2()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');

        // Validación básica
        $rules = [
            'apellido' => 'required|min_length[2]|max_length[100]',
            'nombre' => 'required|min_length[2]|max_length[100]',
            'alias' => 'required|min_length[3]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // Verificar alias único
        $nuevoAlias = $this->request->getPost('alias');
        $db = \Config\Database::connect();
        $builder = $db->table('usuarios');
        $builder->where('alias', $nuevoAlias);
        $builder->where('id !=', $usuarioId);

        if ($builder->get()->getRow()) {
            return redirect()->back()->withInput()->with('error', 'Este alias ya está en uso.');
        }

        // Datos para actualizar
        $data = [
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $nuevoAlias,
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'cargo_actual' => $this->request->getPost('cargo_actual'),
            'dependencia' => $this->request->getPost('dependencia'),
            'mensaje_estado' => $this->request->getPost('mensaje_estado'),
            'estado' => $this->request->getPost('estado'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Actualización directa a la base de datos
        $builder = $db->table('usuarios');
        $builder->where('id', $usuarioId);

        if ($builder->update($data)) {
            $this->session->set([
                'usuario_nombre' => $data['nombre'],
                'usuario_apellido' => $data['apellido'],
                'usuario_alias' => $data['alias'],
                'usuario_estado' => $data['estado']
            ]);

            return redirect()->to('/perfil')->with('success', 'Perfil actualizado correctamente.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar el perfil.');
        }
    }

    public function actualizarPerfil()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        $usuarioId = $this->session->get('usuario_id');

        // Validación básica
        $rules = [
            'apellido' => 'required|min_length[2]|max_length[100]',
            'nombre' => 'required|min_length[2]|max_length[100]',
            'alias' => 'required|min_length[3]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // Verificar alias único
        $nuevoAlias = $this->request->getPost('alias');
        $db = \Config\Database::connect();
        $builder = $db->table('usuarios');
        $builder->where('alias', $nuevoAlias);
        $builder->where('id !=', $usuarioId);

        if ($builder->get()->getRow()) {
            return redirect()->back()->withInput()->with('error', 'Este alias ya está en uso.');
        }

        // Datos para actualizar
        $data = [
            'apellido' => $this->request->getPost('apellido'),
            'nombre' => $this->request->getPost('nombre'),
            'alias' => $nuevoAlias,
            'dni' => $this->request->getPost('dni'),
            'fecha_nacimiento' => $this->request->getPost('fecha_nacimiento'),
            'telefono' => $this->request->getPost('telefono'),
            'direccion' => $this->request->getPost('direccion'),
            'cargo_actual' => $this->request->getPost('cargo_actual'),
            'dependencia' => $this->request->getPost('dependencia'),
            'mensaje_estado' => $this->request->getPost('mensaje_estado'),
            'estado' => $this->request->getPost('estado'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Actualización directa a la base de datos
        $builder = $db->table('usuarios');
        $builder->where('id', $usuarioId);

        if ($builder->update($data)) {
            // Actualizar TODAS las variables de sesión
            $this->session->set([
                'usuario_nombre' => $data['nombre'],
                'usuario_apellido' => $data['apellido'],
                'usuario_alias' => $data['alias'],
                'usuario_estado' => $data['estado'],
                'usuario_mensaje_estado' => $data['mensaje_estado'] // Actualizar también el mensaje de estado
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

    public function recuperarPassword()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        $data = [
            'titulo' => 'Recuperar Contraseña - SGC'
        ];

        return view('auth/recuperar_password', $data);
    }

    public function solicitarRecuperacion()
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/recuperar-password')->with('error', 'Método no permitido');
        }

        $rules = [
            'email' => 'required|valid_email'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        $email = $this->request->getPost('email');
        $usuario = $this->usuarioModel->buscarPorEmail($email);

        if ($usuario) {
            // Generar token único
            $token = bin2hex(random_bytes(32));

            // Guardar token en la base de datos (necesitarías una tabla para tokens)
            // Por simplicidad, aquí simulamos el envío
            log_message('info', "Token de recuperación para $email: $token");

            return redirect()->to('/recuperar-password')->with(
                'success',
                'Se ha enviado un enlace de recuperación a tu email.'
            );
        } else {
            return redirect()->back()->withInput()->with(
                'error',
                'No existe una cuenta con ese email.'
            );
        }
    }

    public function resetearPassword($token = null)
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/dashboard');
        }

        if (!$token) {
            return redirect()->to('/recuperar-password')->with('error', 'Token inválido');
        }

        $data = [
            'titulo' => 'Restablecer Contraseña - SGC',
            'token' => $token
        ];

        return view('auth/resetear_password', $data);
    }

    public function actualizarPassword($token = null)
    {
        if (!$this->request->is('post')) {
            return redirect()->to('/recuperar-password')->with('error', 'Método no permitido');
        }

        if (!$token) {
            return redirect()->to('/recuperar-password')->with('error', 'Token inválido');
        }

        $rules = [
            'password' => 'required|min_length[8]',
            'confirm_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validation->getErrors());
        }

        // En una implementación real, aquí verificarías el token en la base de datos
        // y obtendrías el usuario asociado al token
        $nuevaPassword = $this->request->getPost('password');

        // Simulación de actualización (en realidad necesitarías el email del token)
        log_message('info', "Contraseña actualizada para token: $token");

        return redirect()->to('/login')->with(
            'success',
            'Contraseña restablecida correctamente. Ahora puedes iniciar sesión.'
        );
    }
}