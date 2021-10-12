<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h2>Detail Portfolio</h2>
            <div class="card mb-3 mt-4" style="max-width: 540px;">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="/img/<?= $portfolio['sampul']; ?>" class="img-fluid rounded-start" alt="">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title"><?= $portfolio['judul']; ?></h5>
                            <p class="card-text">
                                <b>Kategori : </b>
                                <?= $portfolio['kategori']; ?>
                            </p>
                            <p class="card-text"><small class="text-muted">
                                    <b>Detail English : </b>
                                    <?= $portfolio['detail_en']; ?>
                                </small></p>
                            <p class="card-text"><small class="text-muted">
                                    <b>Detail Indonesia : </b>
                                    <?= $portfolio['detail_id']; ?>
                                </small></p>
                            <a href="/portfolio/edit/<?= $portfolio['slug']; ?> " class="btn btn-warning">Edit</a>

                            <form action="/portfolio/<?= $portfolio['id']; ?>" method="POST" class="d-inline">
                                <?= csrf_field(); ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ?');"> Delete </button>
                            </form>
                            <br><br>
                            <a href="/portfolio">Kembali ke Daftar portfolio</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>