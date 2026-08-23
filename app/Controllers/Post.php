<?php

namespace App\Controllers;

use App\Services\BlogService;
use App\Services\ContentStatus;
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
        if ($post === null || ContentStatus::normalize($post['situacao'] ?? null) === ContentStatus::DRAFT) {
            throw PageNotFoundException::forPageNotFound('Postagem não encontrada.');
        }

        return view('post', ['post' => $post, 'underReview' => ContentStatus::isReview($post['situacao'] ?? null)]);
    }
}
