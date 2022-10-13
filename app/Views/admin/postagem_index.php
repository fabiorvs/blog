<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">
    <div class="col-md-12" style="text-align: right;">
        <a href="<?=base_url('admin/postagem/novo')?>" class="btn btn-primary btn-xs">Novo Post</a>
    </div>

    <h2 class="text-center">
        Postagens
    </h2>

    <table class="table table-striped custab">
        <thead>
            <tr>
                <th>ID</th>
                <th>Titulo</th>
                <th>Data</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>

        <?php if (count($posts) > 0) : ?>
            <?php foreach ($posts as $post) : ?>

                <tr>
                    <td><?= $post['id'] ?></td>
                    <td><?= $post['titulo'] ?></td>
                    <td><?= data_hora_br($post['created_at']) ?></td>
                    <td class="text-center">
                        <a class='btn btn-success btn-sm' href="<?=base_url('admin/postagem/editar/'.$post['id'])?>">Editar</a> 
                        <a class="btn btn-danger btn-sm" href="<?=base_url('admin/postagem/excluir/'.$post['id'])?>">Excluir</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else : ?>
            Nenhuma postagem.
        <?php endif; ?>

    </table>
    <!-- Pagination-->

    <?php if ($pager) : ?>
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    <?php endif ?>
</div>

<?= $this->endSection() ?>