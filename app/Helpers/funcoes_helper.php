<?php

if (!function_exists("menu_categorias")) {
    function menu_categorias()
    {
        $categoriaModel = new \App\Models\CategoriaModel;
        $categorias = $categoriaModel->get_categorias_menu();
        foreach ($categorias as $categoria) {
            echo '<li><a href="' . base_url('categoria/' . $categoria['slug']) . '">' . $categoria['nome'] . '</a></li>';
        }
    }
}

if (!function_exists("menu_paginas")) {
    function menu_paginas()
    {
        $paginaModel = new \App\Models\PaginaModel;
        $paginas = $paginaModel->get_all_paginas();
        foreach ($paginas as $pagina) {
            echo '<li class="nav-item"><a class="nav-link" href="' . base_url('pagina/' . $pagina['slug']) . '">' . $pagina['nome'] . '</a></li>';
        }
    }
}

// Function: used to create slugs
if (!function_exists("slugify")) {
    function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}

if (!function_exists("data_hora_br")) {
    function data_hora_br($data)
    {
        $data = date('d/m/Y H:i', strtotime($data));
        return $data;
    }
}

if (!function_exists("getUsuario")) {
    function getUsuario($opt)
    {
        switch ($opt) {
            case 'id':
                return '1';
                break;
        }
    }
}

if (!function_exists("valida_slug_post")) {
    function valida_slug_post($slug)
    {
        $postModel = new \App\Models\PostagemModel;
        $posts = $postModel->get_all_post_slug($slug);
        $total =  count($posts);
        if ($total > 0) {
            return $slug . "-" . ($total + 1);
        } else {
            return $slug;
        }
    }
}
if (!function_exists("valida_slug_pagina")) {
    function valida_slug_pagina($slug)
    {
        $paginaModel = new \App\Models\PaginaModel;
        $paginas = $paginaModel->get_all_paginas_slug($slug);
        $total =  count($paginas);
        if ($total > 0) {
            return $slug . "-" . ($total + 1);
        } else {
            return $slug;
        }
    }
}
