<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">

    <form action="<?= base_url('admin/categoria/salvar/' . $categoria['id']) ?>" method="post" enctype="multipart/form-data">
        <h2 class="text-center">
            Editar Categoria
        </h2>

        <div class="form-group">
            <label>Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" value="<?= $categoria['nome'] ?>" required>
        </div>
        <div class="col-2 mt-2 pb-4 ">
            <button class="btn btn-primary btn-block" type="submit">Salvar</button>
            <a href="<?= base_url('admin/categoria') ?>" class="btn btn-danger btn-block">Cancelar</a>
        </div>
    </form>

</div>

<?= $this->endSection() ?>