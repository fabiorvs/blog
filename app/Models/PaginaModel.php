<?php

namespace App\Models;

use CodeIgniter\Model;

class PaginaModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'paginas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nome',
        'conteudo',
        'slug',
        'usuario',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
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

    public function get_paginas()
    {
        return $this->select('paginas.*')
            ->orderBy('created_at', 'desc');
    }

    public function get_all_paginas()
    {
        return $this->orderBy('nome', 'asc')
            ->findAll();
    }

    public function get_pagina_slug($slug)
    {
        return $this->select('usuarios.nome AS nome_usuario, paginas.*')
            ->join('usuarios', 'paginas.usuario = usuarios.id')
            ->where('paginas.slug', $slug)
            ->first();
    }

    public function get_all_paginas_slug($slug)
    {
        return $this->select('paginas.slug')
            ->like('paginas.slug', $slug)
            ->findAll();
    }

    public function get_pagina_id($id)
    {
        return $this->select('usuarios.nome AS nome_usuario, paginas.*')
            ->join('usuarios', 'paginas.usuario = usuarios.id')
            ->where('paginas.id', $id)
            ->first();
    }
}
