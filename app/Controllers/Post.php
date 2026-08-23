<?php

namespace App\Controllers;

use App\Services\BlogService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    private BlogService $blog;

    public function __construct(?BlogService $blog = null)
    {
        $this->blog = $blog ?? new BlogService();
    }

    public function index($slug = null)
    {
        $post = $slug === null ? null : $this->blog->post($slug);
        if ($post === null) {
            throw PageNotFoundException::forPageNotFound('Postagem não encontrada.');
        }

        return view('post', ['post' => $post]);
    }
}
