<?php echo view('header'); ?>


<div class="card">
    <div class="card-header">
        VA Owner List 


            <a class="btn btn-danger btn-sm float-end" href="<?= base_url('va-owner') ?>">Cancel</a>
   
    </div>
    <div class="card-body">
       
       <div class="container mt-4">
    <h4 class="mb-4">Tambah Potesi</h4>
   <form action="<?= isset($va_owner) ? base_url('/va-owner/update/'.$va_owner['va_owner_id']) : base_url('/va-owner/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">VA (Indeks)</label>
        <div class="col-sm-9">
            <input type="text" name="va_owner_va" class="form-control" 
                   value="<?= isset($va_owner) ? esc($va_owner['va_owner_va']) : '' ?>">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Anggota Dishub</label>
        <div class="col-sm-9">
         <select name="va_owner_anggotaid" class="form-select select2" data-placeholder="-- Pilih Anggota --">
            <option value="">-- Pilih Anggota --</option>
            <?php foreach ($anggota as $a): ?>
                <option value="<?= $a['anggota_id'] ?>" <?= isset($va_owner) && $va_owner['va_owner_anggotaid'] == $a['anggota_id'] ? 'selected' : '' ?>>
                    <?= esc($a['anggota_nama']) ?> -- <?= esc($a['titpar_namatempat']) ?>
                </option>
            <?php endforeach; ?>
        </select>
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