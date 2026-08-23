<?php $section = service('uri')->getSegment(2) ?: 'dashboard'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Painel administrativo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin.css?v=' . filemtime(FCPATH . 'assets/css/admin.css')) ?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/admin-analytics.css?v=' . filemtime(FCPATH . 'assets/css/admin-analytics.css')) ?>" rel="stylesheet">
    <?= $this->renderSection('css') ?>
</head>
<body class="admin-body">
<svg class="admin-icon-sprite" aria-hidden="true">
    <symbol id="icon-home" viewBox="0 0 24 24"><path d="M3 11.5 12 4l9 7.5M5.5 10v9h13v-9M9.5 19v-5h5v5"/></symbol>
    <symbol id="icon-posts" viewBox="0 0 24 24"><path d="M5 4h14v16H5zM8 8h8M8 12h8M8 16h5"/></symbol>
    <symbol id="icon-page" viewBox="0 0 24 24"><path d="M6 3h8l4 4v14H6zM14 3v5h4M9 12h6M9 16h6"/></symbol>
    <symbol id="icon-category" viewBox="0 0 24 24"><path d="M4 7.5V4h3.5L19 15.5 15.5 19 4 7.5zM7 7h.01"/></symbol>
    <symbol id="icon-users" viewBox="0 0 24 24"><path d="M16 20v-1.5a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4V20M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM16 4.2a4 4 0 0 1 0 7.6M17.5 14.7a4 4 0 0 1 3.5 3.8V20"/></symbol>
    <symbol id="icon-chart" viewBox="0 0 24 24"><path d="M4 20V10M10 20V4M16 20v-7M22 20H2"/></symbol>
    <symbol id="icon-palette" viewBox="0 0 24 24"><path d="M12 3a9 9 0 1 0 0 18h1.2a1.8 1.8 0 0 0 0-3.6h-.7a1.5 1.5 0 0 1 0-3H15A6 6 0 0 0 12 3z"/><path d="M7.5 10h.01M9 6.8h.01M13 6h.01M16.5 8.5h.01"/></symbol>
    <symbol id="icon-external" viewBox="0 0 24 24"><path d="M14 5h5v5M19 5l-9 9M19 13v6H5V5h6"/></symbol>
    <symbol id="icon-logout" viewBox="0 0 24 24"><path d="M10 5H5v14h5M13 8l4 4-4 4M8 12h9"/></symbol>
    <symbol id="icon-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
</svg>
<div class="admin-shell">
    <aside class="admin-sidebar" id="adminSidebar">
        <a class="admin-brand" href="<?= base_url('admin') ?>"><span class="admin-brand__mark">P</span><span>Painel do Blog<small>Administração</small></span></a>
        <div class="admin-nav-label">Conteúdo</div>
        <nav class="admin-nav" aria-label="Menu administrativo">
            <a class="<?= $section === 'dashboard' ? 'active' : '' ?>" href="<?= base_url('admin') ?>"><svg class="admin-nav__icon"><use href="#icon-home"/></svg>Visão geral</a>
            <a class="<?= $section === 'postagem' ? 'active' : '' ?>" href="<?= base_url('admin/postagem') ?>"><svg class="admin-nav__icon"><use href="#icon-posts"/></svg>Postagens</a>
            <a class="<?= $section === 'pagina' ? 'active' : '' ?>" href="<?= base_url('admin/pagina') ?>"><svg class="admin-nav__icon"><use href="#icon-page"/></svg>Páginas</a>
            <a class="<?= $section === 'categoria' ? 'active' : '' ?>" href="<?= base_url('admin/categoria') ?>"><svg class="admin-nav__icon"><use href="#icon-category"/></svg>Categorias</a>
            <a class="<?= $section === 'usuario' ? 'active' : '' ?>" href="<?= base_url('admin/usuario') ?>"><svg class="admin-nav__icon"><use href="#icon-users"/></svg>Usuários</a>
            <a class="<?= $section === 'estatisticas' ? 'active' : '' ?>" href="<?= base_url('admin/estatisticas') ?>"><svg class="admin-nav__icon"><use href="#icon-chart"/></svg>Estatísticas</a>
        </nav>
        <div class="admin-nav-label mt-3">Personalização</div>
        <nav class="admin-nav"><a class="<?= $section === 'aparencia' ? 'active' : '' ?>" href="<?= base_url('admin/aparencia') ?>"><svg class="admin-nav__icon"><use href="#icon-palette"/></svg>Aparência</a><a href="<?= base_url() ?>" target="_blank" rel="noopener"><svg class="admin-nav__icon"><use href="#icon-external"/></svg>Ver o blog</a></nav>
        <div class="admin-sidebar__footer">
            <div class="admin-user"><span class="admin-user__avatar"><?= esc(strtoupper(substr((string) session('name'), 0, 1))) ?></span><span><?= esc(session('name') ?: 'Administrador') ?><small><?= esc(session('email')) ?></small></span></div>
            <form action="<?= base_url('admin/login/deslogar') ?>" method="post"><?= csrf_field() ?><button class="admin-logout" type="submit"><svg class="admin-icon"><use href="#icon-logout"/></svg>Sair da conta</button></form>
        </div>
    </aside>
    <div class="admin-main">
        <header class="admin-topbar"><button class="admin-mobile-toggle" type="button" aria-label="Abrir menu" onclick="document.getElementById('adminSidebar').classList.toggle('show')">☰</button><p class="admin-topbar__title">Gerencie o conteúdo e a identidade do seu blog</p><div class="admin-topbar__actions"><a class="admin-btn admin-btn--secondary" href="<?= base_url() ?>" target="_blank" rel="noopener">Visualizar site <svg class="admin-icon"><use href="#icon-external"/></svg></a></div></header>
        <main class="admin-content">
            <?php if (session()->has('success')) : ?><div class="alert alert-success" role="status"><?= esc(session('success')) ?></div><?php endif ?>
            <?php if (session()->has('errors')) : ?><div class="alert alert-danger" role="alert"><?php foreach ((array) session('errors') as $erro) : ?><div><?= esc($erro) ?></div><?php endforeach ?></div><?php endif ?>
            <?= $this->renderSection('conteudo') ?>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/ckeditor5/ckeditor.js') ?>"></script>
<script>document.addEventListener('click',function(e){const side=document.getElementById('adminSidebar');if(window.innerWidth<992&&side.classList.contains('show')&&!side.contains(e.target)&&!e.target.closest('.admin-mobile-toggle'))side.classList.remove('show')});</script>
<?= $this->renderSection('js') ?>
</body>
</html>
