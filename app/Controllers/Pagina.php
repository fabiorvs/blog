<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PaginaModel;

class Pagina extends BaseController
{
    public function __construct()
    {
        $this->paginaModel = new PaginaModel();
    }

    public function index($slug)
    {
        $dados = [
            'pagina' => $this->paginaModel->get_pagina_slug($slug)
        ];
        return view('pagina', $dados);
    }
}
