<?php echo view('header'); ?>


<div class="card">
    <div class="card-header">
        VA Owner List <a class="btn btn-primary btn-sm float-end" href="<?= base_url('va-owner/create') ?>">Add New</a>
    </div>
    <div class="card-body">
       
       <div class="container mt-4">
    <h2 class="mb-4">Edit VA Owner</h2>
    <form action="<?= base_url('va-owner/update/' . $owner['va_owner_id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">VA Owner ID Jukir</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="va_owner_id_jukir" value="<?= esc($owner['va_owner_id_jukir']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">VA Owner VA</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="va_owner_va" value="<?= esc($owner['va_owner_va']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">VA Owner Nama</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="va_owner_nama" value="<?= esc($owner['va_owner_nama']) ?>" required>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Berita 1</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="va_owner_berita_1" rows="2"><?= esc($owner['va_owner_berita_1']) ?></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Berita 2</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="va_owner_berita_2" rows="2"><?= esc($owner['va_owner_berita_2']) ?></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">Berita 3</label>
            <div class="col-sm-9">
                <textarea class="form-control" name="va_owner_berita_3" rows="2"><?= esc($owner['va_owner_berita_3']) ?></textarea>
            </div>
        </div>

        <div class="row mb-3">
            <label class="col-sm-3 col-form-label">HP</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="va_owner_hp" value="<?= esc($owner['va_owner_hp']) ?>">
            </div>
        </div>

        <div class="row">
            <div class="offset-sm-3 col-sm-9">
                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= base_url('va-owner') ?>" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </form>
</div>



    </div>
</div>

<?php echo view('footer'); ?>