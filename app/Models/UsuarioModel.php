<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'apellido', 'nombre', 'password', 'mensaje_estado', 'direccion', 
        'email', 'alias', 'dni', 'fecha_nacimiento', 'cargo_actual', 
        'dependencia', 'rol', 'aprobado', 'estado'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'apellido' => 'required|min_length[2]|max_length[100]',
        'nombre' => 'required|min_length[2]|max_length[100]',
        'alias' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.alias]',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'dni' => 'permit_empty|min_length[7]|max_length[10]',
        'fecha_nacimiento' => 'permit_empty|valid_date',
        'password' => 'required|min_length[8]',
        'rol' => 'required|in_list[Usuario,Experto,Sistemas]'
    ];

    protected $validationMessages = [
        'alias' => [
            'is_unique' => 'Este alias ya está en uso. Por favor elige otro.'
        ],
        'email' => [
            'is_unique' => 'Este email ya está registrado.'
        ]
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = ['hashPassword', 'setDefaultValues'];
    protected $beforeUpdate = ['hashPasswordIfChanged'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    protected function hashPasswordIfChanged(array $data)
    {
        if (isset($data['data']['password']) && !empty($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        } else {
            unset($data['data']['password']);
        }
        return $data;
    }

    protected function setDefaultValues(array $data)
    {
        if (!isset($data['data']['rol']) || empty($data['data']['rol'])) {
            $data['data']['rol'] = 'Usuario';
        }
        if (!isset($data['data']['aprobado']) || empty($data['data']['aprobado'])) {
            $data['data']['aprobado'] = 1;
        }
        if (!isset($data['data']['estado']) || empty($data['data']['estado'])) {
            $data['data']['estado'] = 'Activo';
        }
        return $data;
    }

    public function verificarUsuario($email, $password)
    {
        $usuario = $this->where('email', $email)->first();

        if (!$usuario) {
            return false;
        }

        // Verificar si la cuenta está aprobada
        if (!$usuario['aprobado']) {
            return 'cuenta_no_aprobada';
        }

        // Verificar contraseña
        if (password_verify($password, $usuario['password'])) {
            return $usuario;
        }

        return false;
    }

    public function verificarPassword($usuarioId, $passwordActual)
    {
        $usuario = $this->find($usuarioId);

        if ($usuario && password_verify($passwordActual, $usuario['password'])) {
            return true;
        }

        return false;
    }

    public function getUsuariosActivos()
    {
        return $this->where('aprobado', 1)->findAll();
    }

    public function buscarPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function buscarPorAlias($alias)
    {
        return $this->where('alias', $alias)->first();
    }

    public function update($id = null, $data = null): bool
    {
        $this->skipValidation(false);
        return parent::update($id, $data);
    }
}