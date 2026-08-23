<?php

namespace App\Services;

use App\Models\CategoriaModel;
use App\Models\PaginaModel;
use App\Models\PostagemModel;

class AdminContentService
{
    private PostagemModel $postagens;
    private CategoriaModel $categorias;
    private PaginaModel $paginas;

    public function __construct(
        ?PostagemModel $postagens = null,
        ?CategoriaModel $categorias = null,
        ?PaginaModel $paginas = null
    ) {
        $this->postagens = $postagens ?? new PostagemModel();
        $this->categorias = $categorias ?? new CategoriaModel();
        $this->paginas = $paginas ?? new PaginaModel();
    }

    public function posts(int $perPage): array
    {
        return ['posts' => $this->postagens->get_posts()->paginate($perPage), 'pager' => $this->postagens->pager];
    }

    public function dashboard(): array
    {
        return [
            'totalPosts' => $this->postagens->where('id >', 0)->countAllResults(),
            'totalCategories' => $this->categorias->where('id >', 0)->countAllResults(),
            'totalPages' => $this->paginas->where('id >', 0)->countAllResults(),
            'recentPosts' => $this->postagens->get_posts()->findAll(5),
        ];
    }

    public function post(int $id): ?array { return $this->postagens->get_post_id($id); }
    public function categories(): array { return $this->categorias->get_categorias_menu(); }
    public function category(int $id): ?array { return $this->categorias->get_categoria_id($id); }
    public function page(int $id): ?array { return $this->paginas->get_pagina_id($id); }

    public function paginatedCategories(int $perPage): array
    {
        return ['categorias' => $this->categorias->get_categorias()->paginate($perPage), 'pager' => $this->categorias->pager];
    }

    public function paginatedPages(int $perPage): array
    {
        return ['paginas' => $this->paginas->get_paginas()->paginate($perPage), 'pager' => $this->paginas->pager];
    }

    public function savePost(array $data, ?int $id = null): bool
    {
        $data['slug'] = $this->slug($data['slug'] ?? '', $data['titulo'], fn ($slug) => $this->postagens->slugExists($slug, $id));
        if ($id !== null) { $data['id'] = $id; }
        return $this->postagens->save($data);
    }

    public function savePage(array $data, ?int $id = null): bool
    {
        $data['slug'] = $this->slug($data['slug'] ?? '', $data['nome'], fn ($slug) => $this->paginas->slugExists($slug, $id));
        if ($id !== null) { $data['id'] = $id; }
        return $this->paginas->save($data);
    }

    public function saveCategory(array $data, ?int $id = null): bool
    {
        $data['slug'] = $this->slug($data['slug'] ?? '', $data['nome'], fn ($slug) => $this->categorias->slugExists($slug, $id));
        if ($id !== null) { $data['id'] = $id; }
        return $this->categorias->save($data);
    }

    public function deletePost(int $id): bool { return (bool) $this->postagens->delete($id); }
    public function deletePage(int $id): bool { return (bool) $this->paginas->delete($id); }
    public function deleteCategory(int $id): bool { return (bool) $this->categorias->delete($id); }

    private function slug(string $provided, string $title, callable $exists): string
    {
        $base = trim($provided) !== '' ? url_title($provided, '-', true) : url_title($title, '-', true);
        $slug = $base;
        $suffix = 2;
        while ($exists($slug)) { $slug = $base . '-' . $suffix++; }
        return $slug;
    }
}
