<?php echo view('header'); ?>

<?php if (session()->getFlashdata('message')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('message'); ?>
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        VA Owner List 

            <a class="btn btn-danger btn-sm float-end" href="<?= base_url('va-owner') ?>">Cancel</a>
   
    </div>
    <div class="card-body">
       
       <div class="container mt-4">
    <h4 class="mb-4">Pencatatan VA</h4>
   <form action="<?= isset($va_owner) ? base_url('/va-owner/update/'.$va_owner['va_owner_id']) : base_url('/va-owner/store') ?>" method="post">
    <?= csrf_field() ?>
    
  <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Anggota Jukir</label>
    <div class="col-sm-9">
        <select class="form-select select2" data-placeholder="-- Pilih Anggota --"
                name="va_owner_anggota" <?= isset($va_owner) ? 'disabled' : '' ?>>
            <option value="">-- Pilih Anggota --</option>
            <?php foreach ($anggota as $a): ?>
                <?php 
                    $optValue = $a['anggota_id'].';'.$a['anggota_nama'];

                    // Prefer old() if exists, otherwise use $va_owner
                    $currentValue = old('va_owner_anggota') 
                        ?: (isset($va_owner) ? $va_owner['va_owner_anggotaid'].';'.$va_owner['va_owner_nama'] : '');

                    $selected = ($currentValue === $optValue) ? 'selected' : '';
                ?>
                <option value="<?= $optValue ?>" <?= $selected ?>>
                    <?= esc($a['anggota_nama']) ?> -- <?= esc($a['titpar_namatempat']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <?php if (isset($va_owner)): ?>
            <!-- Hidden supaya value tetap terkirim -->
            <input type="hidden" name="va_owner_anggota" 
                   value="<?= $va_owner['va_owner_anggotaid'].';'.$va_owner['va_owner_nama'] ?>">
        <?php endif; ?>
    </div>
</div>



   <div class="row mb-3">
    <label class="col-sm-3 col-form-label">VA (Indeks)</label>
    <div class="col-sm-9">
        <input type="text" name="va_owner_va" 
               class="form-control <?= isset($va_owner) ? 'bg-light text-muted' : '' ?>" 
               value="<?= old('va_owner_va', isset($va_owner) ? esc($va_owner['va_owner_va']) : '') ?>" 
               <?= isset($va_owner) ? 'readonly' : '' ?>>
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">HP</label>
    <div class="col-sm-9">
        <input type="text" name="va_owner_hp" class="form-control"
               pattern="^(0|62)[0-9]+$"
               inputmode="numeric"
               title="Nomor HP harus dimulai dengan 0 atau 62 dan hanya angka"
               value="<?= old('va_owner_hp', isset($va_owner) ? esc($va_owner['va_owner_hp']) : '') ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Email</label>
    <div class="col-sm-9">
        <input type="text" name="va_owner_email" class="form-control" 
               value="<?= old('va_owner_email', isset($va_owner) ? esc($va_owner['va_owner_email']) : 'example@gmail.com') ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Tanggal</label>
    <div class="col-sm-9">
        <input type="date" name="va_owner_expired" class="form-control" 
               value="<?= old('va_owner_expired', $va_owner['va_owner_expired'] ?? date('Y-m-d', strtotime('+1 year'))) ?>">
    </div>
</div>

    <!-- Add more fields here -->

    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?= isset($va_owner) ? 'Update' : 'Submit' ?></button>
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