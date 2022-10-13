<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PaginaModel;

class Pagina extends BaseController
{

    public function __construct()
    {
        $this->paginaModel = new PaginaModel();
        $this->session     = \Config\Services::session();
    }

    public function index()
    {
        $dados = [
            'paginas' => $this->paginaModel->get_paginas()->paginate(getenv('PAGINATION')),
            'pager' => $this->paginaModel->pager,
        ];
        return view('admin/pagina_index', $dados);
    }

    public function novo()
    {
        return view('admin/pagina_novo');
    }

    public function salvar($id = null)
    {
        if ($this->request->getVar('slug')) {
            $slug = $this->request->getVar('slug');
        } else {
            $slug = url_title(strtolower($this->request->getVar('nome')));
            $slug = valida_slug_pagina($slug);
        }
        $dados = [
            'nome' => $this->request->getVar('nome'),
            'slug' => $slug,
            'conteudo' => $this->request->getVar('conteudo'),
            'usuario' => getUsuario('id')

        ];

        if ($id) {
            $dados['id'] = $id;
        }

        if ($this->paginaModel->save($dados)) {
            return redirect()->to('/admin/pagina');
        } else {
            echo "Erro";
        }
    }

    public function editar($id)
    {
        $dados = [
            'pagina' => $this->paginaModel->get_pagina_id($id)
        ];

        return view('admin/pagina_editar', $dados);
    }

    public function excluir($id)
    {
        $dados = [
            'id' => $id,
            'deleted_at' =>  date("Y-m-d H:i:s")
        ];

        if ($this->paginaModel->save($dados)) {
            return redirect()->to('/admin/pagina');
        } else {
            echo "Erro";
        }
    }
}
