<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use App\Models\PostagemModel;

class Postagem extends BaseController
{

    public function __construct()
    {
        $this->postagemModel = new PostagemModel();
        $this->categoriaModel = new CategoriaModel();
        $this->session     = \Config\Services::session();
    }

    public function index()
    {
        $dados = [
            'posts' => $this->postagemModel->get_posts()->paginate(getenv('PAGINATION')),
            'pager' => $this->postagemModel->pager,
        ];
        return view('admin/postagem_index', $dados);
    }

    public function novo()
    {
        $dados = [
            'categorias' =>  $this->categoriaModel->get_categorias()
        ];

        return view('admin/postagem_novo', $dados);
    }

    public function salvar($id = null)
    {
        if ($this->request->getVar('slug')) {
            $slug = $this->request->getVar('slug');
        } else {
            $slug = url_title(strtolower($this->request->getVar('titulo')));
            $slug = valida_slug_post($slug);
        }
        $dados = [
            'titulo' => $this->request->getVar('titulo'),
            'categoria' => $this->request->getVar('categoria'),
            'slug' => $slug,
            'conteudo' => $this->request->getVar('conteudo'),
            'usuario' => getUsuario('id')

        ];
        $imageFile = $this->request->getFile('imagem');
        if (!$imageFile->getName() == "") {

            $validationRule = [
                'imagem' => [
                    'label' => 'Image File',
                    'rules' => 'uploaded[imagem]'
                        . '|is_image[imagem]'
                        . '|mime_in[imagem,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                        . '|max_size[imagem,10000]'
                        . '|max_dims[imagem,3000,3000]',
                ],
            ];
            if (!$this->validate($validationRule)) {
                // $data = ['errors' => $this->validator->getErrors()];
                print_r($this->validator->getErrors());
            } else {
                $newName = $imageFile->getRandomName();
                $imageFile->move(FCPATH . 'uploads', $newName);
                $dados['img'] = $newName;
            }
        }

        if ($id) {
            $dados['id'] = $id;
        }

        if ($this->postagemModel->save($dados)) {
            return redirect()->to('/admin/postagem');
        } else {
            echo "Erro";
        }
    }

    public function editar($id)
    {
        $dados = [
            'post' => $this->postagemModel->get_post_id($id),
            'categorias' =>  $this->categoriaModel->get_categorias()
        ];

        return view('admin/postagem_editar', $dados);
    }

    public function excluir($id)
    {
        $dados = [
            'id' => $id,
            'deleted_at' =>  date("Y-m-d H:i:s")
        ];

        if ($this->postagemModel->save($dados)) {
            return redirect()->to('/admin/postagem');
        } else {
            echo "Erro";
        }
    }
}
