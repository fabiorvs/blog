<?php

namespace App\Services;

use App\Models\CategoriaModel;
use App\Models\PaginaModel;
use App\Models\PostagemModel;

class BlogService
{
    private PostagemModel $postagens;
    private CategoriaModel $categorias;
    private PaginaModel $paginas;
    private ThemeService $theme;

    public function __construct(
        ?PostagemModel $postagens = null,
        ?CategoriaModel $categorias = null,
        ?PaginaModel $paginas = null,
        ?ThemeService $theme = null
    ) {
        $this->postagens = $postagens ?? new PostagemModel();
        $this->categorias = $categorias ?? new CategoriaModel();
        $this->paginas = $paginas ?? new PaginaModel();
        $this->theme = $theme ?? new ThemeService();
    }

    public function home(int $perPage): array
    {
        $theme = $this->theme->settings();
        $featuredId = (int) $theme['featured_post_id'];
        $featured = $featuredId > 0 ? $this->postagens->get_post_id($featuredId) : null;
        if ($featured === null || ! ContentStatus::isPubliclyListed($featured['situacao'] ?? null)) {
            $featured = $this->postagens->get_last_published_post();
        }

        return [
            'featured_post' => $featured,
            'posts' => $this->postagens->get_published_posts()->paginate($perPage),
            'pager' => $this->postagens->pager,
            'categorias' => $this->categorias->get_categorias_menu(),
            'theme' => $theme,
        ];
    }

    public function postsByCategory(string $slug, int $perPage): ?array
    {
        $categoria = $this->categorias->get_id_categoria($slug);
        if ($categoria === null) {
            return null;
        }

        return [
            'posts' => $this->postagens->get_published_posts_categoria($categoria['id'])->paginate($perPage),
            'pager' => $this->postagens->pager,
            'slug' => $slug,
        ];
    }

    public function search(string $term, int $perPage): array
    {
        return [
            'posts' => $this->postagens->get_published_post_pesquisa($term)->paginate($perPage),
            'pager' => $this->postagens->pager,
            'pesquisa' => $term,
        ];
    }

    public function post(string $slug): ?array
    {
        return $this->postagens->get_post_slug($slug);
    }

    public function page(string $slug): ?array
    {
        return $this->paginas->get_pagina_slug($slug);
    }
}
