<?php

namespace App\Controllers;

use App\Services\BlogService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Home extends BaseController
{

    private BlogService $blog;

    public function __construct(?BlogService $blog = null)
    {
        $this->blog = $blog ?? new BlogService();
    }

    public function index()
    {

        return view('home', $this->blog->home($this->perPage()));
    }


    public function categoria($slug = null)
    {

        if ($slug === null || ($dados = $this->blog->postsByCategory($slug, $this->perPage())) === null) {
            throw PageNotFoundException::forPageNotFound('Categoria não encontrada.');
        }

        return view('categoria', $dados);
    }

    public function pesquisa()
    {
        $pesquisa = trim((string) $this->request->getPostGet('pesquisa'));
        if ($pesquisa === '') {
            return view('pesquisa', ['posts' => [], 'pager' => null, 'pesquisa' => '']);
        }

        return view('pesquisa', $this->blog->search($pesquisa, $this->perPage()));
    }
}
