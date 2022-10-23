<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">
    <div class="col-md-12" style="text-align: right;">
        <a href="<?=base_url('admin/categoria/novo')?>" class="btn btn-primary btn-xs">Nova Categoria</a>
    </div>

    <h2 class="text-center">
        Categorias
    </h2>

    <table class="table table-striped custab">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>

        <?php if (count($categorias) > 0) : ?>
            <?php foreach ($categorias as $categoria) : ?>

                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= $categoria['nome'] ?></td>
                    <td class="text-center">
                        <a class='btn btn-success btn-sm' href="<?=base_url('admin/categoria/editar/'.$categoria['id'])?>">Editar</a> 
                        <a class="btn btn-danger btn-sm" href="<?=base_url('admin/categoria/excluir/'.$categoria['id'])?>">Excluir</a>
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