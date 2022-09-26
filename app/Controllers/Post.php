<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\PostagemModel;

class Post extends BaseController
{
    public function __construct()
    {
        $this->postagemModel = new PostagemModel();
        $this->categoriaModel = new CategoriaModel();
    }

    public function index($slug = null)
    {
        $dados = [
            'post' => $this->postagemModel->get_post_slug($slug)
        ];
        return view('post', $dados);
    }
}
