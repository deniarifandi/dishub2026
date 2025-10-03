<?php echo view('header'); ?>

<div class="card">
    <div class="card-header">
        Catat Titik Parkir
        <a class="btn btn-danger btn-sm float-end" href="<?= base_url('titpar') ?>">Cancel</a>
    </div>

    <div class="card-body">
        <div class="container mt-4">
            <h4 class="mb-4">Pencatatan Titik Parkir</h4>

            <form action="<?= isset($titpar) ? base_url('/titpar/update/'.$titpar['titpar_id']) : base_url('/titpar/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Titik Parkir</label>
                    <div class="col-sm-9">
                        <input type="text" id="titpar_namatempat" name="titpar_namatempat" 
                               value="<?= isset($titpar['titpar_namatempat']) ? esc($titpar['titpar_namatempat']) : '' ?>" 
                               class="form-control" required>
                    </div>
                </div>

                <!-- Tambahkan field lain di sini kalau perlu -->

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <?= isset($titpar) ? 'Update' : 'Submit' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php echo view('footer'); ?>
