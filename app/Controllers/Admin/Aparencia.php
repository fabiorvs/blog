<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PostagemModel;
use App\Services\ThemeService;

class Aparencia extends BaseController
{
    private ThemeService $theme;
    private PostagemModel $posts;

    public function __construct(?ThemeService $theme = null, ?PostagemModel $posts = null)
    {
        $this->theme = $theme ?? new ThemeService();
        $this->posts = $posts ?? new PostagemModel();
    }

    public function index()
    {
        return view('admin/aparencia', [
            'theme' => $this->theme->settings(),
            'posts' => $this->posts->select('id, titulo')->where('situacao', 'publicado')->orderBy('created_at', 'DESC')->findAll(),
        ]);
    }

    public function salvar()
    {
        $input = array_merge($this->theme->settings(), (array) $this->request->getPost());
        $input['show_categories'] = $this->request->getPost('show_categories') ? '1' : '0';
        $input['show_newsletter'] = $this->request->getPost('show_newsletter') ? '1' : '0';

        if ($this->request->getPost('remove_logo')) {
            $input['logo_path'] = '';
        }
        if ($this->request->getPost('remove_hero_background')) {
            $input['hero_background_path'] = '';
        }

        try {
            $logo = $this->storeThemeImage('logo');
            $background = $this->storeThemeImage('hero_background');
        } catch (\InvalidArgumentException $exception) {
            return redirect()->back()->withInput()->with('errors', [$exception->getMessage()]);
        }

        if ($logo !== null) {
            $input['logo_path'] = $logo;
        }
        if ($background !== null) {
            $input['hero_background_path'] = $background;
        }

        $this->theme->save($input);

        return redirect()->to('/admin/aparencia')->with('success', 'A aparência do blog foi atualizada.');
    }

    private function storeThemeImage(string $field): ?string
    {
        $file = $this->request->getFile($field);
        if ($file === null || $file->getName() === '') {
            return null;
        }

        if (!$file->isValid()) {
            throw new \InvalidArgumentException('Não foi possível receber a imagem enviada.');
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($file->getMimeType(), $allowedMimes, true) || $file->getSizeByUnit('mb') > 5) {
            throw new \InvalidArgumentException('Envie uma imagem JPG, PNG ou WebP de até 5 MB.');
        }

        $directory = FCPATH . 'uploads/theme';
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \InvalidArgumentException('Não foi possível preparar a pasta de imagens do tema.');
        }

        $name = $field . '-' . $file->getRandomName();
        $file->move($directory, $name);

        return 'uploads/theme/' . $name;
    }
}
