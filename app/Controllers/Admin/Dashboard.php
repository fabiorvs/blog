<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\PostagemModel;

class Dashboard extends BaseController
{

    public function __construct()
    {
        $this->postagemModel = new PostagemModel();
        $this->categoriaModel = new CategoriaModel();
        $this->session     = \Config\Services::session();
    }

    public function index()
    {
        return view('admin/dashboard_index');
    }
}