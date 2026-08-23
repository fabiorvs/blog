<?php

namespace App\Controllers;

use App\Services\BlogService;
use App\Services\ContentStatus;
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
        if ($pagina === null || ContentStatus::normalize($pagina['situacao'] ?? null) === ContentStatus::DRAFT) {
            throw PageNotFoundException::forPageNotFound('Página não encontrada.');
        }

        return view('pagina', ['pagina' => $pagina, 'underReview' => ContentStatus::isReview($pagina['situacao'] ?? null)]);
    }
}
