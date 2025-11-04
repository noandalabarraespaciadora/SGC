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
    protected $allowedFields = ['nombre', 'apellido', 'alias', 'direccion', 'email', 'telefono', 'password', 'nivel', 'activo'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation - SOLO para inserción
    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
        'apellido' => 'required|min_length[2]|max_length[100]',
        'alias' => 'required|min_length[3]|max_length[50]|is_unique[usuarios.alias]',
        'email' => 'required|valid_email|is_unique[usuarios.email]',
        'telefono' => 'permit_empty|min_length[8]|max_length[20]',
        'direccion' => 'permit_empty|max_length[500]',
        'password' => 'required|min_length[8]',
        'nivel' => 'required|in_list[usuario,sistema]'
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
    protected $beforeInsert = ['hashPassword', 'setDefaultNivel'];
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
            // Si no se está cambiando la contraseña, removerla de los datos
            unset($data['data']['password']);
        }
        return $data;
    }

    protected function setDefaultNivel(array $data)
    {
        if (!isset($data['data']['nivel']) || empty($data['data']['nivel'])) {
            $data['data']['nivel'] = 'usuario';
        }
        return $data;
    }

    public function verificarUsuario($email, $password)
    {
        $usuario = $this->where('email', $email)->where('activo', 1)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {
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
        return $this->where('activo', 1)->findAll();
    }

    public function buscarPorEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function buscarPorAlias($alias)
    {
        return $this->where('alias', $alias)->first();
    }

    // MÉTODO SOBREESCRITO PARA ACTUALIZACIÓN - CLAVE PARA SOLUCIONAR EL PROBLEMA
    public function update($id = null, $data = null): bool
    {
        // Para actualizaciones, no usar las validaciones por defecto
        $this->skipValidation(false);
        return parent::update($id, $data);
    }
}