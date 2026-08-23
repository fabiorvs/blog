<?php

namespace App\Controllers;

use App\Services\BlogService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Pagina extends BaseController
{
    private BlogService $blog;

    public function __construct(?BlogService $blog = null)
    {
        $this->blog = $blog ?? new BlogService();
    }

    public function index($slug)
    {
        $pagina = $this->blog->page($slug);
        if ($pagina === null) {
            throw PageNotFoundException::forPageNotFound('Página não encontrada.');
        }

        return view('pagina', ['pagina' => $pagina]);
    }
}
