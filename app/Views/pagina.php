<?= $this->extend('layout') ?>
<?= $this->section('conteudo') ?>

<!-- Post content-->
<article>
    <!-- Post header-->
    <header class="mb-4">
        <!-- Post title-->
        <h1 class="fw-bolder mb-1"><?= $pagina['nome'] ?></h1>
        <!-- Post meta content-->
        <!-- <div class="text-muted fst-italic mb-2">Postado em <?= data_hora_br($pagina['created_at']) ?> por <?= $pagina['nome_usuario'] ?></div> -->
        
    </header>
    <!-- Preview image figure-->
    
    <!-- Post content-->
    <section class="mb-5">
        <?= $pagina['conteudo'] ?>
    </section>
</article>

<?= $this->endSection() ?>