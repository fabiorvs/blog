<?php

namespace App\Models;

use CodeIgniter\Model;

class PostagemModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'postagens';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields     = [
        'categoria',
        'titulo',
        'subtitulo',
        'conteudo',
        'slug',
        'img',
        'exibir_capa',
        'usuario',
        'situacao',
        'created_at',
        'updated_at',
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

    public function get_last_post()
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function get_last_published_post()
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->where('postagens.situacao', 'publicado')
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function get_posts()
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->orderBy('created_at', 'desc');
    }

    public function get_published_posts()
    {
        return $this->get_posts()->where('postagens.situacao', 'publicado');
    }

    public function get_posts_categoria($id_categoria)
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->where('categoria', $id_categoria)
            ->orderBy('created_at', 'desc');
    }

    public function get_published_posts_categoria($id_categoria)
    {
        return $this->get_posts_categoria($id_categoria)->where('postagens.situacao', 'publicado');
    }

    public function get_post_slug($slug)
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->where('postagens.slug', $slug)
            ->first();
    }

    public function get_all_post_slug($slug)
    {
        return $this->select('postagens.slug')
            ->like('postagens.slug', $slug)
            ->findAll();
    }

    public function slugExists(string $slug, ?int $exceptId = null): bool
    {
        $builder = db_connect($this->DBGroup)->table($this->table)
            ->where('slug', $slug)
            ->where($this->deletedField, null);
        if ($exceptId !== null) { $builder->where('id !=', $exceptId); }
        return $builder->countAllResults() > 0;
    }

    public function get_post_id($id)
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->where('postagens.id', $id)
            ->first();
    }

    public function get_post_pesquisa($pesquisa)
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->like('postagens.titulo', $pesquisa)
            ->orLike('postagens.conteudo', $pesquisa)
            ->orderBy('created_at', 'desc');
    }

    public function get_published_post_pesquisa($pesquisa)
    {
        return $this->select('categorias.nome AS nome_categoria, categorias.slug AS slug_categoria, usuarios.nome AS nome_usuario, postagens.*')
            ->join('categorias', 'postagens.categoria = categorias.id')
            ->join('usuarios', 'postagens.usuario = usuarios.id')
            ->where('postagens.situacao', 'publicado')
            ->groupStart()
                ->like('postagens.titulo', $pesquisa)
                ->orLike('postagens.conteudo', $pesquisa)
            ->groupEnd()
            ->orderBy('created_at', 'desc');
    }
}
