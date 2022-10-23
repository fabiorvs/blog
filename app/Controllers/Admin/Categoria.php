<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;

class Categoria extends BaseController
{

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
        $this->session     = \Config\Services::session();
    }

    public function index()
    {
        $dados = [
            'categorias' => $this->categoriaModel->get_categorias()->paginate(getenv('PAGINATION')),
            'pager' => $this->categoriaModel->pager,
        ];
        return view('admin/categoria_index', $dados);
    }

    public function novo()
    {
        return view('admin/categoria_novo');
    }

    public function salvar($id = null)
    {


        $dados = [
            'nome' => $this->request->getVar('nome'),
            'slug' => url_title(strtolower($this->request->getVar('nome')))
        ];

        if ($id) {
            $dados['id'] = $id;
        }

        if ($this->categoriaModel->save($dados)) {
            return redirect()->to('/admin/categoria');
        } else {
            echo "Erro";
        }
    }

    public function editar($id)
    {
        $dados = [
            'categoria' => $this->categoriaModel->get_categoria_id($id)
        ];
        return view('admin/categoria_editar', $dados);
    }

    public function excluir($id)
    {
        $dados = [
            'id' => $id,
            'deleted_at' =>  date("Y-m-d H:i:s")
        ];
        if ($this->categoriaModel->save($dados)) {
            return redirect()->to('/admin/categoria');
        } else {
            echo "Erro";
        }
    }
}
