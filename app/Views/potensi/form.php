<?php echo view('header'); ?>


<div class="card">
    <div class="card-header">
        Pencatatan Potensi

        <a class="btn btn-danger btn-sm float-end" href="<?= base_url('potensi') ?>">Cancel</a>
   
    </div>
    <div class="card-body">
       
       <div class="container mt-4">
    <h4 class="mb-4">Pencatatan Potesi</h4>
   <form action="<?= isset($data) ? base_url('/potensi/store/'.$data['va_owner_va']) : base_url('/potensi/store') ?>" method="post">
    <?= csrf_field() ?>
    
    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">VA (Indeks)</label>
        <div class="col-sm-9">
            <input type="text" name="va_owner_va" class="form-control" 
                   value="<?= isset($data) ? esc($data['va_owner_va']) : '' ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Nama Anggota</label>
        <div class="col-sm-9">
            <input type="text" class="form-control " 
                   value="<?= isset($data) ? esc($data['anggota_id']." - ".$data['anggota_nama']) : '' ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tempat Parkir</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" 
                   value="<?= isset($data) ? esc($data['titpar_id']." - ".$data['titpar_namatempat']." - ".$data['titpar_lokasi']) : '' ?>" readonly>
        </div>
    </div>

    <div class="row mb-3">
    <label class="col-sm-3 col-form-label">Senin</label>
    <div class="col-sm-9">
        <input type="text" name="senin" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['senin'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Selasa</label>
    <div class="col-sm-9">
        <input type="text" name="selasa" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['selasa'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Rabu</label>
    <div class="col-sm-9">
        <input type="text" name="rabu" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['rabu'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Kamis</label>
    <div class="col-sm-9">
        <input type="text" name="kamis" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['kamis'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Jumat</label>
    <div class="col-sm-9">
        <input type="text" name="jumat" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['jumat'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Sabtu</label>
    <div class="col-sm-9">
        <input type="text" name="sabtu" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['sabtu'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Minggu</label>
    <div class="col-sm-9">
        <input type="text" name="minggu" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['minggu'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Mingguan</label>
    <div class="col-sm-9">
        <input type="text" name="mingguan" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['mingguan'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Bulanan</label>
    <div class="col-sm-9">
        <input type="text" name="bulanan" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['bulanan'] : '' ?>">
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-3 col-form-label">Tahunan</label>
    <div class="col-sm-9">
        <input type="text" name="tahunan" class="form-control autonumeric" 
               value="<?= isset($data) ? $data['tahunan'] : '' ?>">
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