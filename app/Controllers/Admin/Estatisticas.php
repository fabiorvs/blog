<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Services\AnalyticsService;
class Estatisticas extends BaseController { public function index() { return view('admin/estatisticas',(new AnalyticsService())->report((string)$this->request->getGet('period'))); } }
