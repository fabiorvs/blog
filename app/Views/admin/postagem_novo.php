<?= $this->extend('admin/layout') ?>
<?= $this->section('conteudo') ?>

<div class="row">

    <form action="<?= base_url('admin/postagem/salvar') ?>" method="post" enctype="multipart/form-data">
        <h2 class="text-center">
            Nova Postagem
        </h2>

        <div class="form-group">
            <label>Título</label>
            <input type="text" class="form-control" name="titulo" id="titulo" required>
        </div>
        <div class="form-group mt-2">
            <label>Categoria</label>
            <select class="form-control" name="categoria" id="categoria" required>
                <option value="">Selecione a categoria</option>
                <?php foreach ($categorias as $categoria) : ?>
                    <option value="<?= $categoria['id'] ?>"><?= $categoria['nome'] ?></option>
                <?php endforeach; ?>

            </select>
        </div>
        <div class="form-group mt-2">
            <label>Imagem destaque</label><br>
            <input type="file" class="form-control-file" accept="image/*" name="imagem" id="imagem" required>
        </div>
        <div class="form-group mt-2 pb-4">
            <label>Texto</label>
            <textarea class="form-control" style="width: 100%; height: 400px;" id="conteudo" name="conteudo"></textarea>
        </div>

        <div class="col-2 mt-2 pb-4 ">
            <button class="btn btn-primary btn-block" type="submit">Salvar</button>
            <a href="<?= base_url('admin/postagem') ?>" class="btn btn-danger btn-block">Cancelar</a>
        </div>
    </form>

</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>

<script type="text/javascript">
    // CKEDITOR.replace('conteudo', {
    //     height: 400,
    //     width: '100%',
    //     expand: true,
    //     filebrowserUploadUrl: "<?= base_url('assets/ckeditor/upload.php') ?>"
    // });

    ClassicEditor.create(document.querySelector('#conteudo'), {

        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(error => {
            console.error('Oops, something went wrong!');
            console.error('Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:');
            console.warn('Build id: e10r8tjxmfle-8k5z603wm8ij');
            console.error(error);
        });
</script>

<?= $this->endSection() ?>