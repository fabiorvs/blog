<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">
    <div class="col-md-12" style="text-align: right;">
        <a href="<?= base_url('admin/pagina/novo') ?>" class="btn btn-primary btn-xs">Nova Página</a>
    </div>

    <h2 class="text-center">
        Páginas
    </h2>

    <table class="table table-striped custab">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Data</th>
                <th class="text-center">Ações</th>
            </tr>
        </thead>

        <?php if (count($paginas) > 0) : ?>
            <?php foreach ($paginas as $pagina) : ?>

                <tr>
                    <td><?= $pagina['id'] ?></td>
                    <td><?= $pagina['nome'] ?></td>
                    <td><?= data_hora_br($pagina['created_at']) ?></td>
                    <td class="text-center">
                        <a class='btn btn-success btn-sm' href="<?= base_url('admin/pagina/editar/' . $pagina['id']) ?>">Editar</a>
                        <a class="btn btn-danger btn-sm" href="<?= base_url('admin/pagina/excluir/' . $pagina['id']) ?>">Excluir</a>
                    </td>
                </tr>

            <?php endforeach; ?>
        <?php else : ?>
            Nenhuma página.
        <?php endif; ?>

    </table>
    <!-- Pagination-->

    <?php if ($pager) : ?>
        <?= $pager->links('default', 'bootstrap_pagination') ?>
    <?php endif ?>
</div>

<?= $this->endSection() ?>