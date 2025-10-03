<?php echo view('header'); ?>

<div class="card">
    <div class="card-header">
        Catat Titik Parkir Anggota
        <a class="btn btn-danger btn-sm float-end" href="<?= base_url('titpargrup') ?>">Cancel</a>
    </div>

    <div class="card-body">
        <div class="container mt-4">
            <h4 class="mb-4">Pencatatan Titik Parkir Anggota</h4>

          <?php $action = isset($titpargrup['titpargrup_id']) 
                ? base_url('/titpargrup/update/'.$titpargrup['titpargrup_id']) 
                : base_url('/titpargrup/store'); ?>

            <form action="<?= $action ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Anggota</label>
                    <div class="col-sm-9">
                        <select id="titpargrup_anggotaid" name="titpargrup_anggotaid" class="form-select select2" required>
                            <option value="">-- Pilih Anggota --</option>
                            <?php foreach ($anggotaList as $a): ?>
                                <option value="<?= $a['anggota_id']; ?>" 
                                    <?= (isset($titpargrup['titpargrup_anggotaid']) && $titpargrup['titpargrup_anggotaid'] == $a['anggota_id']) ? 'selected' : '' ?>>
                                    <?= esc($a['anggota_nama']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">Nama Titik Parkir</label>
                    <div class="col-sm-9">
                        <select id="titpargrup_titparid" name="titpargrup_titparid" class="form-select select2" required>
                            <option value="">-- Pilih Titik Parkir --</option>
                            <?php foreach ($titparList as $t): ?>
                                <option value="<?= $t['titpar_id']; ?>" 
                                    <?= (isset($titpargrup['titpargrup_titparid']) && $titpargrup['titpargrup_titparid'] == $t['titpar_id']) ? 'selected' : '' ?>>
                                    <?= esc($t['titpar_namatempat']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>



                <!-- Tambahkan field lain di sini kalau perlu -->

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <?= isset($titpargrup) ? 'Update' : 'Submit' ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $(document).ready(function() {
    $('.select2').select2({
      theme: 'bootstrap4', // match Bootstrap 4/5 styles
      width: '100%',       // fix width issue
      allowClear: true
    });
  });
</script>

<?php echo view('footer'); ?>
