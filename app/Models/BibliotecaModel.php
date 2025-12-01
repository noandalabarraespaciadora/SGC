<?php

namespace App\Models;

use CodeIgniter\Model;

class BibliotecaModel extends Model
{
    protected $table            = 'biblioteca';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'titulo',
        'autor',
        'editorial',
        'n_isbn',
        'n_inventario',
        'url_foto',
        'ubicacion',
        'descripcion'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'titulo' => 'required|max_length[255]',
        'autor' => 'max_length[255]',
        'editorial' => 'max_length[255]',
        'n_isbn' => 'max_length[20]',
        'n_inventario' => 'required|max_length[50]',
        'ubicacion' => 'max_length[255]'
    ];
    protected $validationMessages = [
        'titulo' => [
            'required' => 'El campo título es obligatorio.',
            'max_length' => 'El título no puede tener más de 255 caracteres.'
        ],
        'autor' => [
            'max_length' => 'El autor no puede tener más de 255 caracteres.'
        ],
        'editorial' => [
            'max_length' => 'La editorial no puede tener más de 255 caracteres.'
        ],
        'n_isbn' => [
            'max_length' => 'El ISBN no puede tener más de 20 caracteres.'
        ],
        'n_inventario' => [
            'required' => 'El número de inventario es obligatorio.',
            'max_length' => 'El número de inventario no puede tener más de 50 caracteres.'
        ],
        'ubicacion' => [
            'max_length' => 'La ubicación no puede tener más de 255 caracteres.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function validarCreacion($data)
    {
        $rules = [
            'titulo' => 'required|max_length[255]|is_unique[biblioteca.titulo,deleted_at,]',
            'autor' => 'max_length[255]',
            'editorial' => 'max_length[255]',
            'n_isbn' => 'max_length[20]',
            'n_inventario' => 'required|max_length[50]|is_unique[biblioteca.n_inventario,deleted_at,]',
            'ubicacion' => 'max_length[255]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function validarEdicion($data, $id)
    {
        $rules = [
            'titulo' => "required|max_length[255]|is_unique[biblioteca.titulo,id,{$id},deleted_at,]",
            'autor' => 'max_length[255]',
            'editorial' => 'max_length[255]',
            'n_isbn' => 'max_length[20]',
            'n_inventario' => "required|max_length[50]|is_unique[biblioteca.n_inventario,id,{$id},deleted_at,]",
            'ubicacion' => 'max_length[255]'
        ];
        $this->setValidationRules($rules);
        return $this->validate($data);
    }

    public function getLibros()
    {
        return $this->where('deleted_at', null)->orderBy('titulo', 'ASC')->findAll();
    }

    public function search($term)
    {
        return $this->where('deleted_at', null)
            ->groupStart()
            ->like('titulo', $term)
            ->orLike('autor', $term)
            ->orLike('editorial', $term)
            ->orLike('n_isbn', $term)
            ->orLike('n_inventario', $term)
            ->orLike('ubicacion', $term)
            ->groupEnd()
            ->orderBy('titulo', 'ASC')
            ->findAll();
    }
}
