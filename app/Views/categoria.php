<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>
<div class="container listing-shell">
    <span class="eyebrow">Categoria</span>
    <h1 class="listing-title"><?= esc(ucwords(str_replace('-', ' ', $slug))) ?></h1>
    <?= $this->include('_article_grid') ?>
    <?php if ($pager) : ?><?php $pager->setPath('categoria/' . $slug) ?><div class="theme-pagination"><?= $pager->links('default', 'bootstrap_pagination') ?></div><?php endif ?>
</div>
<?= $this->endSection() ?>
