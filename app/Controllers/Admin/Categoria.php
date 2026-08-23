<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminContentService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Categoria extends BaseController
{

    private AdminContentService $content;

    public function __construct(?AdminContentService $content = null)
    {
        $this->content = $content ?? new AdminContentService();
    }

    public function index()
    {
        return view('admin/categoria_index', $this->content->paginatedCategories($this->perPage()));
    }

    public function novo()
    {
        return view('admin/categoria_novo');
    }

    public function salvar($id = null)
    {


        $dados = ['nome' => trim((string) $this->request->getPost('nome'))];
        if ($dados['nome'] === '') {
            return redirect()->back()->withInput()->with('errors', ['nome' => 'Informe o nome da categoria.']);
        }

        if ($this->content->saveCategory($dados, $id === null ? null : (int) $id)) {
            return redirect()->to('/admin/categoria')->with('success', 'Categoria salva com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', ['Não foi possível salvar a categoria.']);
    }

    public function editar($id)
    {
        $categoria = $this->content->category((int) $id);
        if ($categoria === null) { throw PageNotFoundException::forPageNotFound('Categoria não encontrada.'); }
        return view('admin/categoria_editar', ['categoria' => $categoria]);
    }

    public function excluir($id)
    {
        if ($this->content->deleteCategory((int) $id)) {
            return redirect()->to('/admin/categoria')->with('success', 'Categoria excluída com sucesso.');
        }

        return redirect()->back()->with('errors', ['Não foi possível excluir a categoria.']);
    }
}
