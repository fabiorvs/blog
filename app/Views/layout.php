<?php $theme = (new \App\Services\ThemeService())->settings(); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= esc($theme['site_description'], 'attr') ?>">
    <?= $this->renderSection('meta') ?>
    <title><?= esc($theme['site_name']) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Libre+Franklin:wght@400;500;600&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/theme-brand.css?v=' . filemtime(FCPATH . 'assets/css/theme-brand.css')) ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/high/styles/codepen-embed.min.css') ?>">
    <style>:root{--theme-primary:<?= esc($theme['primary_color']) ?>;--theme-accent:<?= esc($theme['accent_color']) ?>;--theme-bg:<?= esc($theme['background_color']) ?>;--theme-text:<?= esc($theme['text_color']) ?>}</style>
    <?= $this->renderSection('estilos') ?>
</head>
<body>
    <header class="site-header">
        <div class="container site-header__inner">
            <a class="site-brand" href="<?= base_url() ?>" aria-label="<?= esc($theme['site_name'], 'attr') ?>">
                <?= esc($theme['site_name']) ?>
            </a>
            <button class="site-menu-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#siteNavigation" aria-controls="siteNavigation" aria-expanded="false" aria-label="Abrir menu">☰</button>
            <nav class="collapse site-navigation" id="siteNavigation" aria-label="Navegação principal"><a href="<?= base_url() ?>">Início</a><?php menu_paginas() ?></nav>
            <form class="site-search" action="<?= base_url('pesquisar') ?>" method="get" role="search">
                <label class="visually-hidden" for="header-search">Pesquisar</label><input id="header-search" name="pesquisa" type="search" placeholder="Pesquisar artigos"><button type="submit" aria-label="Pesquisar">⌕</button>
            </form>
        </div>
    </header>
    <main><?= $this->renderSection('conteudo') ?></main>
    <footer class="site-footer">
        <div class="container site-footer__inner">
            <div><a class="site-brand" href="<?= base_url() ?>" aria-label="<?= esc($theme['site_name'], 'attr') ?>"><?php if ($theme['logo_path'] !== '') : ?><img class="site-brand__logo site-brand__logo--footer" src="<?= base_url($theme['logo_path']) ?>" alt="<?= esc($theme['site_name'], 'attr') ?>"><?php else : ?><?= esc($theme['site_name']) ?><?php endif ?></a><p><?= esc($theme['footer_text']) ?></p></div>
            <div class="site-footer__links"><a href="<?= base_url() ?>">Início</a><?php menu_paginas() ?></div>
            <p class="site-footer__copyright">© <?= date('Y') ?> <?= esc($theme['site_name']) ?></p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/high/highlight.min.js') ?>"></script>
    <script>if(window.hljs)hljs.highlightAll();</script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
