<?php echo view('header'); ?>


<div class="card">
    <div class="card-header">
        Pencatatan Potensi

        <a class="btn btn-danger btn-sm float-end" href="<?= base_url('potensi') ?>">Cancel</a>
   
    </div>
    <div class="card-body">
       
       <div class="container mt-4">
    <h4 class="mb-4">Pencatatan Potesi</h4>
   <form action="<?= isset($data) ? base_url('/potensi/update/'.$data['va_owner_id']) : base_url('/potensi/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">VA (Indeks)</label>
        <div class="col-sm-9">
            <input type="text" name="va_owner_va" class="form-control" 
                   value="<?= isset($data) ? esc($data['va_owner_va']) : '' ?>">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nama Anggota</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" 
                   value="<?= isset($data) ? esc($data['anggota_id']." - ".$data['anggota_nama']) : '' ?>">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tempat Parkir</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" 
                   value="<?= isset($data) ? esc($data['titpar_id']." - ".$data['titpar_namatempat']." - ".$data['titpar_lokasi']) : '' ?>">
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Senin</label>
        <div class="col-sm-9">
            <input type="text" class="form-control autonumeric" 
                   value="<?= isset($data)? $data['senin'] : ''?>">
        </div>
    </div>

    <!-- Add more fields here -->

    <div class="text-end">
        <button type="submit" class="btn btn-primary"><?= isset($data) ? 'Update' : 'Submit' ?></button>
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

<script>
  document.querySelectorAll('.autonumeric').forEach(el => {
    new AutoNumeric(el, {
      digitGroupSeparator: ',',
      decimalCharacter: '.',
      decimalPlaces: 0,
      unformatOnSubmit: true
    });
  });
</script>
<?php echo view('footer'); ?>