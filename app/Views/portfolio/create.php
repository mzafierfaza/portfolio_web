<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Tambah Data Portfolio</h2>
            <!-- listError artinya mengambil seluruh yg error -->

            <form action="/portfolio/save" method="POST" enctype="multipart/form-data">
                <!-- Untuk menghindari pembajakan form dari luar -->
                <?= csrf_field(); ?>
                <div class="row mb-3">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= old('judul'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="kategori" name="kategori" value="<?= old('kategori'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="detail_en" class="col-sm-2 col-form-label">Detail English</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="detail_en" name="detail_en" value="<?= old('detail_en'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="detail_id" class="col-sm-2 col-form-label">Detail Indonesia</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="detail_id" name="detail_id" value="<?= old('detail_id'); ?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-2">
                        <img src="/img/default.jpg" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" name="sampul" onchange="previewImg()">
                            <!-- <label class="custom-file-label" for="Sampul"></label> -->
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Tambah Data</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>