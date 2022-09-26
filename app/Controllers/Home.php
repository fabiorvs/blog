<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\PostagemModel;
use App\Models\PaginaModel;

class Home extends BaseController
{

    public function __construct()
    {
        $this->postagemModel = new PostagemModel();
        $this->categoriaModel = new CategoriaModel();
        $this->paginaModel = new PaginaModel();
        $this->session     = \Config\Services::session();
    }

    public function index()
    {

        $dados = [
            'featured_post' => $this->postagemModel->get_last_post(),
            'posts' => $this->postagemModel->get_posts()->paginate(getenv('PAGINATION')),
            'pager' => $this->postagemModel->pager
        ];
        return view('home', $dados);
    }


    public function categoria($slug = null)
    {

        if ($slug == null) {
            $dados = [
                'pager' => $this->postagemModel->pager,
                'posts' => array()
            ];
        } else {
            $categoria =  $this->categoriaModel->get_id_categoria($slug);
            $dados = [
                'posts' => $this->postagemModel->get_posts_categoria($categoria['id'])->paginate(getenv('PAGINATION')),
                'pager' => $this->postagemModel->pager,
                'slug' => $slug
            ];
        }
        return view('categoria', $dados);
    }

    public function pesquisa()
    {
        $metodo =   $_SERVER['REQUEST_METHOD'];
        if ($metodo == 'POST') {
            $pesquisa = $this->request->getPost('pesquisa');
        } else {
            $pesquisa = $this->session->getFlashdata('pesquisa');
        }
        if (!$pesquisa) {
            $dados = [
                'pager' => $this->postagemModel->pager,
                'posts' => array()
            ];
        } else {
            $retorno = $this->postagemModel->get_post_pesquisa($pesquisa);
            if ($retorno == null) {
                $dados = [
                    'pager' => $this->postagemModel->pager,
                    'posts' => array()
                ];
            } else {
                $this->session->setFlashdata('pesquisa', $pesquisa);
                $dados = [
                    'posts' => $retorno->paginate(getenv('PAGINATION')),
                    'pager' => $this->postagemModel->pager,
                    'pesquisa' => $pesquisa
                ];
            }
        }
        return view('pesquisa', $dados);
    }
}
