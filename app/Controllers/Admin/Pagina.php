<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminContentService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pagina extends BaseController
{

    private AdminContentService $content;

    public function __construct(?AdminContentService $content = null)
    {
        $this->content = $content ?? new AdminContentService();
    }

    public function index()
    {
        return view('admin/pagina_index', $this->content->paginatedPages($this->perPage()));
    }

    public function novo()
    {
        return view('admin/pagina_novo');
    }

    public function salvar($id = null)
    {
        $dados = [
            'nome' => trim((string) $this->request->getPost('nome')),
            'titulo' => trim((string) $this->request->getPost('titulo')),
            'slug' => trim((string) $this->request->getPost('slug')),
            'conteudo' => (string) $this->request->getPost('conteudo'),
            'usuario' => (int) session()->get('id'),
        ];
        if ($dados['nome'] === '' || $dados['titulo'] === '' || trim($dados['conteudo']) === '') {
            return redirect()->back()->withInput()->with('errors', ['Preencha o nome do link, o título e o conteúdo.']);
        }

        if ($this->content->savePage($dados, $id === null ? null : (int) $id)) {
            return redirect()->to('/admin/pagina')->with('success', 'Página salva com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', ['Não foi possível salvar a página.']);
    }

    public function editar($id)
    {
        $pagina = $this->content->page((int) $id);
        if ($pagina === null) { throw PageNotFoundException::forPageNotFound('Página não encontrada.'); }
        return view('admin/pagina_editar', ['pagina' => $pagina]);
    }

    public function excluir($id)
    {
        if ($this->content->deletePage((int) $id)) {
            return redirect()->to('/admin/pagina')->with('success', 'Página excluída com sucesso.');
        }

        return redirect()->back()->with('errors', ['Não foi possível excluir a página.']);
    }
}
