<?= $this->extend('layout') ?>
<?php if ($underReview ?? false) : ?><?= $this->section('meta') ?><meta name="robots" content="noindex,nofollow"><?= $this->endSection() ?><?php endif ?>
<?= $this->section('conteudo') ?>
<article class="post-shell page-shell page-shell--<?= esc(preg_replace('/[^a-z0-9-]/', '', strtolower($pagina['slug'])), 'attr') ?>">
    <?php if ($underReview ?? false) : ?><div class="content-review-notice" role="status"><strong>Conteúdo em fase de aprovação</strong><span>Esta página ainda não está publicada e só pode ser visualizada por meio do link direto.</span></div><?php endif ?>
    <span class="eyebrow"><?= esc($pagina['nome']) ?></span>
    <h1><?= esc($pagina['titulo'] ?: $pagina['nome']) ?></h1>
    <div class="post-content"><?= $pagina['conteudo'] ?></div>
</article>
<?= $this->endSection() ?>
