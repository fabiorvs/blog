<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>
<div class="container listing-shell">
    <span class="eyebrow">Resultados</span>
    <h1 class="listing-title"><?= !empty($pesquisa) ? 'Busca por “' . esc($pesquisa) . '”' : 'Pesquisar artigos' ?></h1>
    <?= $this->include('_article_grid') ?>
    <?php if ($pager) : ?><div class="theme-pagination"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
</div>
<?= $this->endSection() ?>
