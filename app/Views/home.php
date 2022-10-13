<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>

<?php if($featured_post):?>
<!-- Featured blog post-->
<div class="card mb-4">
    <a href="<?= base_url('post/' . $featured_post['slug']) ?>"><img class="card-img-top" src="<?= base_url('uploads/'.$featured_post['img']) ?>" alt="..." /></a>
    <div class="card-body">
        <div class="small text-muted"><?= $featured_post['created_at'] ?></div>
        <h2 class="card-title"><?= $featured_post['titulo'] ?></h2>
        <p class="card-text"><?= $featured_post['subtitulo'] ?></p>
        <p class="badge bg-secondary text-decoration-none link-light"><?= $featured_post['nome_categoria'] ?></p>
        <p class="card-text"><?= strip_tags(word_limiter(nl2br($featured_post['conteudo']), 50, '...')) ?></p>
        <a class="btn btn-primary" href="<?= base_url('post/' . $featured_post['slug']) ?>">Ler</a>
    </div>
</div>
<?php endif;?>
<!-- Nested row for non-featured blog posts-->
<div class="row">
    <?php if (count($posts) > 0) : ?>
        <?php foreach ($posts as $post) : ?>
            <div class="col-lg-6">
                <!-- Blog post-->
                <div class="card mb-4">
                    <a href="<?= base_url('post/' . $post['slug']) ?>"><img class="card-img-top" src="<?= base_url('uploads/'.$post['img']) ?>" alt="..." /></a>
                    <div class="card-body">
                        <div class="small text-muted"><?= $post['created_at'] ?></div>
                        <h2 class="card-title h4"><?= $post['titulo'] ?></h2>
                        <p class="badge bg-secondary text-decoration-none link-light"><?= $post['nome_categoria'] ?></p>
                        <p class="card-text"><?= $post['subtitulo'] ?></p>
                        <a class="btn btn-primary" href="<?= base_url('post/' . $post['slug']) ?>">Ler</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        Nenhuma postagem.
    <?php endif; ?>

</div>
<!-- Pagination-->

<?php if ($pager) : ?>
    <?= $pager->links('default', 'bootstrap_pagination') ?>
<?php endif ?>
<?= $this->endSection() ?>