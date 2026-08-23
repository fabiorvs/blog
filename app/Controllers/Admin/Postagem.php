<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Services\AdminContentService;
use App\Services\ContentStatus;
use CodeIgniter\Exceptions\PageNotFoundException;

class Postagem extends BaseController
{

    private AdminContentService $content;

    public function __construct(?AdminContentService $content = null)
    {
        $this->content = $content ?? new AdminContentService();
    }

    public function index()
    {
        return view('admin/postagem_index', $this->content->posts($this->perPage()));
    }

    public function novo()
    {
        $dados = [
            'categorias' => $this->content->categories(),
        ];

        return view('admin/postagem_novo', $dados);
    }

    public function salvar($id = null)
    {
        $dados = [
            'titulo' => trim((string) $this->request->getPost('titulo')),
            'subtitulo' => trim((string) $this->request->getPost('subtitulo')),
            'categoria' => (int) $this->request->getPost('categoria'),
            'slug' => trim((string) $this->request->getPost('slug')),
            'conteudo' => (string) $this->request->getPost('conteudo'),
            'exibir_capa' => $this->request->getPost('exibir_capa') ? 1 : 0,
            'situacao' => ContentStatus::normalize($this->request->getPost('situacao')),
            'usuario' => (int) session()->get('id'),
        ];

        if ($dados['titulo'] === '' || $dados['subtitulo'] === '' || $dados['categoria'] < 1 || trim($dados['conteudo']) === '') {
            return redirect()->back()->withInput()->with('errors', ['Preencha título, resumo, categoria e conteúdo.']);
        }

        $imageFile = $this->request->getFile('imagem');
        if ($imageFile !== null && $imageFile->getName() !== '') {
            $validationRule = [
                'imagem' => [
                    'rules' => 'uploaded[imagem]|max_size[imagem,5120]|is_image[imagem]',
                    'errors' => [
                        'uploaded' => 'Por favor, selecione uma imagem para carregar.',
                        'max_size' => 'O tamanho máximo permitido para a imagem é de 5 MB.',
                        'is_image' => 'O arquivo selecionado não é uma imagem válida.',
                    ],
                ],
            ];
            if (!$this->validate($validationRule)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $newName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads', $newName);
            $dados['img'] = $newName;
        }

        if ($this->content->savePost($dados, $id === null ? null : (int) $id)) {
            return redirect()->to('/admin/postagem')->with('success', 'Postagem salva com sucesso.');
        }

        return redirect()->back()->withInput()->with('errors', ['Não foi possível salvar a postagem.']);
    }

    public function editar($id)
    {
        $post = $this->content->post((int) $id);
        if ($post === null) { throw PageNotFoundException::forPageNotFound('Postagem não encontrada.'); }

        $dados = ['post' => $post, 'categorias' => $this->content->categories()];

        return view('admin/postagem_editar', $dados);
    }

    public function excluir($id)
    {
        if ($this->content->deletePost((int) $id)) {
            return redirect()->to('/admin/postagem')->with('success', 'Postagem excluída com sucesso.');
        }

        return redirect()->back()->with('errors', ['Não foi possível excluir a postagem.']);
    }
}
