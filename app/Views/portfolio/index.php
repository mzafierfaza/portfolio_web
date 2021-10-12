<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">

            <a href="/portfolio/create" class="btn btn-primary mt-3 ">Tambah Data Portfolio</a>
            <h2 class="mt-2">Daftar Portfolio</h2>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sampul</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <? $i = 1; ?>
                    <?php foreach ($portfolio as $k) : ?>
                        <tr>
                            <th scope="row"><?= $i; ?></th>
                            <td><img src="/img/<?= $k['sampul']; ?>" class="sampul" alt=""></td>
                            <td><?= $k['judul']; ?></td>
                            <td>
                                <a href="/portfolio/<?= $k['slug']; ?>" class="btn btn-success">Detail</a>
                            </td>
                        </tr>
                        <? $i++; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>