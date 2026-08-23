<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>
<article class="post-shell page-shell page-shell--<?= esc(preg_replace('/[^a-z0-9-]/', '', strtolower($pagina['slug'])), 'attr') ?>">
    <span class="eyebrow"><?= esc($pagina['nome']) ?></span>
    <h1><?= esc($pagina['titulo'] ?: $pagina['nome']) ?></h1>
    <div class="post-content"><?= $pagina['conteudo'] ?></div>
</article>
<?= $this->endSection() ?>
