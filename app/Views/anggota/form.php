<?php echo view('header'); ?>

<div class="card">
    <div class="card-header">
        Catat Anggota
        <a class="btn btn-danger btn-sm float-end" href="<?= base_url('anggota') ?>">Cancel</a>
    </div>

    <div class="card-body">
        <div class="container mt-4">
            <h4 class="mb-4">Pencatatan Anggota</h4>

            <form action="<?= isset($anggota) ? base_url('/anggota/update/'.$anggota['anggota_id']) : base_url('/anggota/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Anggota</label>
                    <div class="col-sm-9">
                        <input type="text" id="anggota_nama" name="anggota_nama" 
                               value="<?= isset($anggota['anggota_nama']) ? esc($anggota['anggota_nama']) : '' ?>" 
                               class="form-control" required>
                    </div>
                </div>

                <!-- Tambahkan field lain di sini kalau perlu -->

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <?= isset($anggota) ? 'Update' : 'Submit' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo view('footer'); ?>
