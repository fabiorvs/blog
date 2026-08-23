<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminContentService;

class Dashboard extends BaseController
{
    private AdminContentService $content;

    public function __construct(?AdminContentService $content = null)
    {
        $this->content = $content ?? new AdminContentService();
    }

    public function index()
    {
        return view('admin/dashboard_index', $this->content->dashboard());
    }
}
